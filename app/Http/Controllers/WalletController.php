<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\EthereumService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    protected $ethereumService;

    public function __construct(EthereumService $ethereumService)
    {
        $this->ethereumService = $ethereumService;
    }

    /**
     * Affiche les détails du portefeuille.
     */
    public function show()
    {
        $user = Auth::user();
        $wallet = $user->wallet;

        return view('wallet.show', compact('wallet'));
    }

    /**
     * Affiche le formulaire de dépôt.
     */
    public function showDepositForm()
    {
        return view('wallet.deposit');
    }

    /**
     * Traite un dépôt.
     */
    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.0001',
        ]);

        $user = Auth::user();
        $wallet = $user->wallet;

        // Simuler un dépôt pour l'environnement de test
        $success = $this->ethereumService->deposit($wallet, $request->amount);

        if ($success) {
            // Enregistrer la transaction
            Transaction::create([
                'sender_id' => $user->id,  // Dans un dépôt, l'expéditeur est l'utilisateur lui-même
                'receiver_id' => $user->id,
                'amount' => $request->amount,
                'type' => 'deposit',
                'status' => 'completed',
                'description' => 'Dépôt de fonds'
            ]);

            return redirect()->route('wallet.show')
                ->with('success', 'Dépôt de ' . $request->amount . ' FCFA effectué avec succès.');
        }

        return back()->withErrors(['amount' => 'Erreur lors du dépôt.']);
    }

    /**
     * Affiche le formulaire de retrait.
     */
    public function showWithdrawForm()
    {
        return view('wallet.withdraw');
    }

    /**
     * Traite un retrait.
     */
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.0001',
        ]);

        $user = Auth::user();
        $wallet = $user->wallet;

        // Vérifier que l'utilisateur a suffisamment de fonds
        if ($wallet->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Solde insuffisant.']);
        }

        // Simuler un retrait pour l'environnement de test
        $wallet->balance -= $request->amount;
        $wallet->save();

        // Enregistrer la transaction
        Transaction::create([
            'sender_id' => $user->id,
            'receiver_id' => $user->id,  // Dans un retrait, le destinataire est l'utilisateur lui-même
            'amount' => $request->amount,
            'type' => 'withdrawal',
            'status' => 'completed',
            'description' => 'Retrait de fonds'
        ]);

        return redirect()->route('wallet.show')
            ->with('success', 'Retrait de ' . $request->amount . ' FCFA effectué avec succès.');
    }
}
