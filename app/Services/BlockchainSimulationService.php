<?php

namespace App\Services;

use App\Models\BlockchainTransaction;
use App\Models\Transaction;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BlockchainSimulationService
{
    /**
     * Génère un hash de transaction Ethereum
     */
    public function generateTransactionHash(): string
    {
        return '0x' . Str::random(64);
    }

    /**
     * Génère un hash de bloc Ethereum
     */
    public function generateBlockHash(): string
    {
        return '0x' . Str::random(64);
    }

    /**
     * Génère une adresse Ethereum
     */
    public function generateAddress(): string
    {
        return '0x' . Str::random(40);
    }

    /**
     * Simule une transaction blockchain
     */
    public function simulateTransaction(Transaction $transaction, Wallet $senderWallet, Wallet $receiverWallet): BlockchainTransaction
    {
        // Créer ou obtenir les adresses des wallets si elles n'existent pas
        if (!$senderWallet->address) {
            $senderWallet->address = $this->generateAddress();
            $senderWallet->save();
        }

        if (!$receiverWallet->address) {
            $receiverWallet->address = $this->generateAddress();
            $receiverWallet->save();
        }

        // Simuler les détails de la transaction blockchain
        $nonce = rand(1, 1000000);
        $gasPrice = rand(20, 100) * 1e9; // En Gwei
        $gasLimit = 21000; // Transaction standard ETH

        // Décider aléatoirement du statut initial
        $status = $this->getRandomInitialStatus();

        // Créer la transaction blockchain
        $blockchainTx = new BlockchainTransaction([
            'transaction_hash' => $transaction->transaction_hash,
            'from_address' => $senderWallet->address,
            'to_address' => $receiverWallet->address,
            'gas_price' => $gasPrice / 1e18, // Convertir en ETH
            'nonce' => $nonce,
            'amount' => $transaction->amount,
            'initiated_at' => Carbon::now()->subMilliseconds(rand(10, 500)),
            'network_fee' => $transaction->amount*0.00005,
            'network_name' => 'Ethereum',
            'transaction_id' => $transaction->id,
            'status' => $status
        ]);

        // Si le statut est "pending" ou "processing", pas de block_hash
        if ($status === 'confirmed') {
            $blockchainTx->block_hash = $this->generateBlockHash();
            $blockchainTx->block_number = rand(10000000, 20000000);
            $blockchainTx->gas_used = $gasLimit;
            $blockchainTx->processed_at = Carbon::now();
            $blockchainTx->confirmations = rand(1, 30);
        } elseif ($status === 'failed' || $status === 'dropped') {
            $blockchainTx->failure_reason = $this->getRandomFailureReason();
            $blockchainTx->processed_at = Carbon::now();
        } elseif ($status === 'processing') {
            $blockchainTx->confirmations = rand(0, 2);
        }

        $blockchainTx->save();

        // Mettre à jour le statut de la transaction originale
        $transaction->status = $this->mapBlockchainStatusToTransactionStatus($status);
        $transaction->save();

        return $blockchainTx;
    }

    /**
     * Obtient un statut initial aléatoire pour la transaction
     */
    private function getRandomInitialStatus(): string
    {
        $statuses = [
            'pending' => 5,      // 50% des transactions sont en attente
            'processing' => 2,   // 20% des transactions sont en cours de traitement
            'confirmed' => 2,    // 20% des transactions sont confirmées
            'failed' => 0.8,     // 8% des transactions échouent
            'dropped' => 0.2     // 2% des transactions sont abandonnées
        ];

        $total = array_sum($statuses);
        $random = rand(0, $total * 10) / 10;

        $cumulative = 0;
        foreach ($statuses as $status => $probability) {
            $cumulative += $probability;
            if ($random <= $cumulative) {
                return $status;
            }
        }

        return 'pending'; // Par défaut
    }

    /**
     * Obtient une raison d'échec aléatoire
     */
    private function getRandomFailureReason(): string
    {
        $reasons = [
            'Erreur de contrat: out of gas',
            'Transaction rejetée: nonce trop élevé',
            'Transaction rejetée: solde insuffisant pour les frais',
            'Erreur réseau: nœuds non synchronisés',
            'Erreur de validation: signature invalide',
            'Erreur EVM: exception lors de l\'exécution',
            'Limite de gas dépassée',
            'Revert: condition non satisfaite',
            'Transaction expirée: délai dépassé',
            'Erreur RPC: connexion perdue avec le nœud',
        ];

        return $reasons[array_rand($reasons)];
    }

    /**
     * Mappe le statut blockchain au statut de transaction
     */
    private function mapBlockchainStatusToTransactionStatus(string $blockchainStatus): string
    {
        switch ($blockchainStatus) {
            case 'pending':
            case 'processing':
                return 'pending';
            case 'confirmed':
                return 'completed';
            case 'failed':
            case 'dropped':
                return 'failed';
            default:
                return 'pending';
        }
    }

    /**
     * Mise à jour du statut d'une transaction blockchain
     * Cette méthode peut être appelée par un job programmé
     */
    public function updateTransactionStatus(BlockchainTransaction $blockchainTx): void
    {
        // Ne pas mettre à jour les transactions déjà confirmées ou échouées
        if ($blockchainTx->status === 'confirmed' || $blockchainTx->status === 'failed' || $blockchainTx->status === 'dropped') {
            return;
        }

        // Options de progression aléatoire
        $options = [
            'pending' => ['pending' => 0.3, 'processing' => 0.6, 'failed' => 0.1],
            'processing' => ['processing' => 0.4, 'confirmed' => 0.5, 'failed' => 0.1]
        ];

        $currentStatus = $blockchainTx->status;
        $statusOptions = $options[$currentStatus] ?? ['pending' => 1];

        $random = mt_rand(1, 100) / 100;
        $cumulative = 0;

        foreach ($statusOptions as $status => $probability) {
            $cumulative += $probability;
            if ($random <= $cumulative) {
                $blockchainTx->status = $status;
                break;
            }
        }

        // Si le statut a changé
        if ($blockchainTx->status !== $currentStatus) {
            if ($blockchainTx->status === 'confirmed') {
                $blockchainTx->block_hash = $this->generateBlockHash();
                $blockchainTx->block_number = rand(10000000, 20000000);
                $blockchainTx->gas_used = 21000;
                $blockchainTx->processed_at = Carbon::now();
                $blockchainTx->confirmations = rand(1, 5);
            } elseif ($blockchainTx->status === 'failed') {
                $blockchainTx->failure_reason = $this->getRandomFailureReason();
                $blockchainTx->processed_at = Carbon::now();
            }
        } else if ($blockchainTx->status === 'processing' || $blockchainTx->status === 'confirmed') {
            // Incrémente les confirmations pour les transactions en cours
            $blockchainTx->confirmations += rand(1, 3);
        }

        $blockchainTx->save();

        // Mettre à jour le statut de la transaction originale
        $transaction = Transaction::find($blockchainTx->transaction_id);
        if ($transaction) {
            $transaction->status = $this->mapBlockchainStatusToTransactionStatus($blockchainTx->status);
            $transaction->save();
        }
    }
}