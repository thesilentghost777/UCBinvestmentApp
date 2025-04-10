<?php

namespace App\Jobs;

use App\Models\BlockchainTransaction;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\BlockchainSimulationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdatePendingTransactions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(BlockchainSimulationService $blockchainService): void
    {
        Log::info('Démarrage de la mise à jour des transactions en attente');

        // Récupérer toutes les transactions blockchain en attente ou en cours
        $pendingTransactions = BlockchainTransaction::whereIn('status', ['pending', 'processing'])
            ->get();

        Log::info('Nombre de transactions en attente: ' . $pendingTransactions->count());

        foreach ($pendingTransactions as $blockchainTx) {
            // Mise à jour du statut
            $oldStatus = $blockchainTx->status;
            $blockchainService->updateTransactionStatus($blockchainTx);

            // Si le statut a changé de processing à confirmed, mettre à jour le solde du destinataire
            if ($oldStatus !== 'confirmed' && $blockchainTx->status === 'confirmed') {
                $transaction = Transaction::find($blockchainTx->transaction_id);

                if ($transaction) {
                    $recipientWallet = Wallet::where('user_id', $transaction->receiver_id)->first();

                    if ($recipientWallet) {
                        $recipientWallet->balance = $recipientWallet->balance + $transaction->amount;
                        $recipientWallet->save();

                        Log::info('Transaction #' . $transaction->id . ' confirmée - Solde du destinataire mis à jour');
                    }
                }
            }

            // Si le statut a changé en échec, rembourser l'expéditeur
            if ($oldStatus !== 'failed' && $blockchainTx->status === 'failed') {
                $transaction = Transaction::find($blockchainTx->transaction_id);

                if ($transaction) {
                    $senderWallet = Wallet::where('user_id', $transaction->sender_id)->first();

                    if ($senderWallet) {
                        $senderWallet->balance = $senderWallet->balance + ($transaction->amount + $transaction->fee);
                        $senderWallet->save();

                        Log::info('Transaction #' . $transaction->id . ' échouée - Remboursement effectué');
                    }
                }
            }

            if ($oldStatus !== $blockchainTx->status) {
                Log::info('Transaction blockchain #' . $blockchainTx->id . ' mise à jour: ' . $oldStatus . ' -> ' . $blockchainTx->status);
            }
        }

        Log::info('Mise à jour des transactions terminée');
    }
}