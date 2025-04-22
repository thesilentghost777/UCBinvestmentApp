<?php

namespace App\Http\Controllers;

use App\Models\Retrait;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetraitController extends Controller
{


    public function index()
    {
        $user = Auth::user();

        $retraits = $user->retraits()->latest('date_demande')->paginate(10);
        $totalRetire = $user->retraits()->where('statut', 'validé')->sum('montant');
        $retraitsEnAttente = $user->retraits()->where('statut', 'en_attente')->count();
        $montantEnAttente = $user->retraits()->where('statut', 'en_attente')->sum('montant');

        return view('retraits.index', compact('retraits', 'totalRetire', 'retraitsEnAttente', 'montantEnAttente'));
    }

    public function create()
    {
        $user = Auth::user();
        $montantMinimumRetrait2 = 3000; // Montant minimum de retrait fixé à 3000 XAF

        return view('retraits.create', compact('montantMinimumRetrait2'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $montantMinimumRetrait = 3250; // Montant minimum de retrait fixé à 3000 XAF
        $frais = 0.07; // 7% de frais sur le montant du retrait

        $request->validate([
            'montant' => 'required|numeric|min:' . $montantMinimumRetrait . '|max:' . $user->solde_actuel,
            'numero_reception' => 'required|string|min:8|max:20',
        ]);

        $montantFrais = $request->montant * $frais;
        $montantfinal = $request->montant - $montantFrais;
        // Vérifier si l'utilisateur a déjà un retrait en attente
        $retraitEnAttente = $user->retraits()->where('statut', 'en_attente')->first();
        if ($retraitEnAttente) {
            return redirect()->route('retraits.index')
                ->with('warning', 'Vous avez déjà une demande de retrait en attente. Veuillez attendre qu\'elle soit traitée avant d\'en soumettre une nouvelle.');
        }

        // Créer le retrait
        $retrait = Retrait::create([
            'user_id' => $user->id,
            'montant' => $montantfinal,
            'date_demande' => now(),
            'numero_reception' => $request->numero_reception,
            'statut' => 'en_attente'
        ]);

        // Déduire le montant du solde de l'utilisateur
        $user->solde_actuel -= $request->montant;
        $user->save();

        // Créer une transaction
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'retrait',
            'montant' => -$request->montant,
            'date_transaction' => now(),
            'description' => 'Demande de retrait #' . $retrait->id
        ]);

        return view('retraits.confirmation', compact('retrait'));
    }
}
