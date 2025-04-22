<?php

namespace App\Http\Controllers;

use App\Models\Investissement;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvestissementController extends Controller
{

    public function index()
    {
        return view('investissements.index');
    }

    public function create()
    {
        return view('investissements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        $package = Package::findOrFail($request->package_id);

        // Vérifier que le package est actif
        if (!$package->actif) {
            return redirect()->route('investissements.create')
                ->with('error', 'Ce package n\'est plus disponible.');
        }

        // Générer un numéro de dépôt aléatoire (numéro de téléphone administrateur)
        $user = Auth::user();
        $numeroDepot = $user->numero_telephone;

        #verifions d'abord s'il n'a pas un autre investissement en attente
        $verif = Investissement::where('user_id',$user->id)
        ->where('statut','en_attente')
        ->first();

        if ($verif) {
            return redirect()->back()->withErrors('Vous avez déjà un investissement en attente de validation, veuillez le compléter.');
        }

        // Créer l'investissement
        $investissement = Investissement::create([
            'user_id' => Auth::id(),
            'package_id' => $package->id,
            'date_initiation' => now(),
            'montant' => $package->montant_investissement,
            'numero_depot' => $numeroDepot,
            'statut' => 'en_attente'
        ]);

        // Créer une transaction
        Transaction::create([
            'user_id' => Auth::id(),
            'type' => 'investissement',
            'montant' => $package->montant_investissement,
            'date_transaction' => now(),
            'description' => 'Initiation d\'investissement - ' . $package->nom
        ]);
        return redirect()->route('payment.required', ['investissement' => $investissement->id]);

    }

    public function attente(Request $request, Investissement $investissement)
{
    // Valider les données
    $validated = $request->validate([
        'tel_paiement' => 'required|regex:/^[6-9][0-9]{8}$/',
    ]);

    // Mettre à jour l'investissement avec les infos de paiement
    $investissement->update([
        'numero_depot' => $request->tel_paiement,
        'status' => 'en_attente'
    ]);

    // Afficher tous les paramètres envoyés dans la requête
    return view('investissements.attente',compact('investissement'));
}

    public function show(Investissement $investissement)
    {
        // Vérifier que l'utilisateur est bien le propriétaire
        if ($investissement->user_id !== Auth::id()) {
            return redirect()->route('investissements.index')
                ->with('error', 'Vous n\'êtes pas autorisé à accéder à cet investissement.');
        }

        return view('investissements.show', compact('investissement'));
    }
}