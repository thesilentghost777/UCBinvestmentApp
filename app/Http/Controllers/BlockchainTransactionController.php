<?php

namespace App\Http\Controllers;

use App\Models\BlockchainTransaction;
use App\Models\Transaction;
use App\Services\BlockchainSimulationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockchainTransactionController extends Controller
{
    protected $blockchainService;

    public function __construct(BlockchainSimulationService $blockchainService)
    {
        $this->blockchainService = $blockchainService;
    }

    /**
     * Afficher les détails d'une transaction par son hash
     */
    public function show(Request $request, $hash = null)
    {
        // Si un hash est passé via l'URL, l'utiliser
        $transactionHash = $hash ?? $request->input('hash');

        if (!$transactionHash) {
            return view('transactions.search');
        }

        $blockchainTx = BlockchainTransaction::where('transaction_hash', $transactionHash)->first();

        if (!$blockchainTx) {
            return redirect()->route('transaction.search')
                ->withErrors(['hash' => 'Transaction non trouvée. Vérifiez le hash et réessayez.']);
        }

        // Vérifier que l'utilisateur est autorisé à voir cette transaction
        $transaction = Transaction::find($blockchainTx->transaction_id);
        $user = Auth::user();

        if ($transaction && ($transaction->sender_id != $user->id && $transaction->receiver_id != $user->id) && !$user->hasRole('admin')) {
            return redirect()->route('transaction.search')
                ->withErrors(['hash' => 'Vous n\'êtes pas autorisé à consulter cette transaction.']);
        }

        // Si la transaction est en attente, la mettre à jour
        if ($blockchainTx->isPending()) {
            $this->blockchainService->updateTransactionStatus($blockchainTx);
            $blockchainTx->refresh(); // Recharger depuis la DB
        }

        return view('transactions.details', [
            'blockchainTx' => $blockchainTx,
            'transaction' => $transaction
        ]);
    }

    /**
     * Afficher le formulaire de recherche de transaction
     */
    public function search()
    {
        return view('transactions.search');
    }

    /**
     * Lister les transactions de l'utilisateur actuel
     */
    public function index()
    {
        $user = Auth::user();

        $transactions = Transaction::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with('blockchainTransaction')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }
}