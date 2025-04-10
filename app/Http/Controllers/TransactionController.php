<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\UserPin;
use App\Services\EthereumService;
use App\Services\BlockchainSimulationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TransactionController extends Controller
{
    protected $ethereumService;

    public function __construct(EthereumService $ethereumService)
    {
        $this->ethereumService = $ethereumService;
    }

    /**
     * Affiche la liste des transactions.
     */
    public function index()
    {
        $user = Auth::user();

        // Fetch transactions for the user, either as sender or receiver
        $transactions = Transaction::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->with('blockchainTransaction') // Eager load the blockchain transactions
            ->paginate(10);

        // Pass the transactions (with blockchain transactions) to the view
        return view('transactions.index', compact('transactions'));
    }

    public function simulate2()
    {
        $user = Auth::user();
        $id = $user->id;
        $transaction = Transaction::findOrFail($id);
        $blockchainTransaction = $transaction->blockchainTransaction;

        if (!$blockchainTransaction) {
            return redirect()->route('transactions.show', $id)
                ->with('error', 'Aucune transaction blockchain associée trouvée.');
        }

        return view('transactions.simulate', compact('transaction', 'blockchainTransaction'));
    }

    public function index2(Request $request)
    {
    $id = $request->input('id');
    $transaction = Transaction::find($id);
    // Récupérer la transaction blockchain associée
    $blockchainTransaction = $transaction->blockchainTransaction;

    // Vérifier si une transaction blockchain existe
    if (!$blockchainTransaction) {
        return redirect()->route('transactions.show', $id)
            ->with('error', 'Aucune transaction blockchain associée trouvée.');
    }

    // Afficher la vue avec les données nécessaires
    return view('transactions.simulate', compact('transaction', 'blockchainTransaction'));
    }


    /**
     * Affiche le formulaire de transfert.
     */
    public function showTransferForm()
    {
        $user = auth()->user();
        $friends = $user->friends()
        ->where('status', 'accepted')
        ->with('friend')
        ->get();

        $user = auth()->user();
        $balance = Wallet::where('user_id', $user->id)->first()->balance;
return view('transactions.transfer', compact('friends', 'balance'));
    }

    /**
     * Vérifie si un utilisateur existe en fonction de son numéro de téléphone.
     */
    public function checkUser(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
        ]);

        $user = User::where('phone_number', $request->phone_number)->first();

        if ($user) {
            return response()->json([
                'exists' => true,
                'user' => [
                    'id' => $user->id,
                    'full_name' => $user->full_name,
                    'phone_number' => $user->phone_number,
                ]
            ]);
        }

        return response()->json(['exists' => false]);
    }

    function generateEthereumTransactionHash(): string {
        // Générer des octets aléatoires
        $randomBytes = random_bytes(32);

        // Convertir en hexadécimal et ajouter le préfixe 0x
        $transactionHash = '0x' . bin2hex($randomBytes);

        return $transactionHash;
    }
    /**
     * Traite un transfert.
     */

public function transfer(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:10',
        'pin' => 'required|digits:4',
        'recipient_type' => 'required|in:friend,manual',
    ]);

    if ($request->recipient_type === 'friend') {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);
        $recipient = User::findOrFail($request->friend_id);
    } else {
        $request->validate([
            'recipient' => 'required|string',
        ]);
        $recipient = User::where('username', $request->recipient)
            ->orWhere('email', $request->recipient)
            ->orWhere('phone_number', $request->recipient)
            ->first();

        if (!$recipient) {
            return redirect()->back()->withErrors(['recipient' => 'Destinataire introuvable.']);
        }
    }

    $sender = Auth::user();

    // Verify PIN
    $userPin = UserPin::where('user_id', $sender->id)->first();
    if (!$userPin || !Hash::check($request->pin, $userPin->pin_hash)) {
        return redirect()->back()->withErrors(['pin' => 'Code PIN incorrect.']);
    }

    if ($sender->id === $recipient->id) {
        return redirect()->back()->withErrors(['recipient' => 'Vous ne pouvez pas effectuer un transfert vers vous-même.']);
    }

    $amount = $request->input('amount');
    $fee = $amount * 0.001; // 0.1% fee
    $totalAmount = $amount + $fee;

    $senderWallet = Wallet::where('user_id', $sender->id)->first();
    if ($senderWallet->balance < $totalAmount) {
        return redirect()->back()->withErrors(['amount' => 'Solde insuffisant. Frais de transfert: ' . number_format($fee, 2) . ' XAF']);
    }

    // Injection du service de simulation blockchain
    $blockchainService = app(BlockchainSimulationService::class);

    // Génère un hash de transaction pour simuler une transaction blockchain
    $transactionHash = $blockchainService->generateTransactionHash();

    $transaction = null;
    $blockchainTx = null;

    DB::transaction(function () use ($sender, $recipient, $amount, $fee, $transactionHash, $blockchainService, &$transaction, &$blockchainTx, &$senderWallet) {
        // Créer la transaction
        $transaction = Transaction::create([
            'sender_id' => $sender->id,
            'receiver_id' => $recipient->id,
            'type' => 'transfer',
            'amount' => $amount,
            'status' => 'pending', // Initialement en attente
            'transaction_hash' => $transactionHash,
            'description' => 'Transfert de ' . $amount . ' XAF à ' . $recipient->username
        ]);

        // Mettre à jour le solde
        $senderWallet->balance = $senderWallet->balance - ($amount + $fee);
        $senderWallet->save();

        $recipientWallet = Wallet::where('user_id', $recipient->id)->first();

        // Simuler la transaction blockchain
        $blockchainTx = $blockchainService->simulateTransaction($transaction, $senderWallet, $recipientWallet);

        // Si la transaction est immédiatement confirmée, mettre à jour le solde du destinataire
        if ($blockchainTx->status === 'confirmed') {
            $recipientWallet->balance = $recipientWallet->balance + $amount;
            $recipientWallet->save();
        }
    });

    // Redirection selon le statut de la transaction blockchain
    if ($blockchainTx->status === 'confirmed') {
        return redirect()->route('dashboard')->with('success', 'Transfert effectué avec succès à ' . $recipient->username . '! Transaction confirmée. Hash: ' . $transactionHash);
    } elseif ($blockchainTx->status === 'failed' || $blockchainTx->status === 'dropped') {
        // Rembourser l'utilisateur en cas d'échec
        $senderWallet->balance = $senderWallet->balance + ($amount + $fee);
        $senderWallet->save();

        return redirect()->route('dashboard')->with('error', 'La transaction a échoué: ' . $blockchainTx->failure_reason . '. Hash: ' . $transactionHash);
    } else {
        return redirect()->route('transaction.status', ['hash' => $transactionHash])
            ->with('info', 'Votre transaction est en cours de traitement. Vous pouvez suivre son statut. Hash: ' . $transactionHash);
    }
}

    // ... keep existing code (history, show, verifyIdentity)

    /**
     * Set user PIN code
     */
    public function setPin(Request $request)
    {
        $request->validate([
            'pin' => 'required|digits:4|confirmed',
        ]);

        $user = Auth::user();

        // Check if user already has a PIN
        $userPin = UserPin::where('user_id', $user->id)->first();

        if ($userPin) {
            // Update existing PIN
            $userPin->pin_hash = Hash::make($request->pin);
            $userPin->save();
        } else {
            // Create new PIN
            UserPin::create([
                'user_id' => $user->id,
                'pin_hash' => Hash::make($request->pin),
            ]);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Code PIN défini avec succès.');
    }

    /**
     * Show form to set PIN
     */
    public function showSetPinForm2()
    {
        return view('set-pin');
    }
    /**
     * Affiche les détails d'une transaction.
     */
    public function show(Transaction $transaction)
    {
        // Vérifier que l'utilisateur est autorisé à voir cette transaction
        $user = Auth::user();
        if ($transaction->sender_id !== $user->id && $transaction->receiver_id !== $user->id) {
            abort(403, 'Non autorisé à voir cette transaction.');
        }

        return view('transactions.show', compact('transaction'));
    }
}
