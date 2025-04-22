<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investissement;
use App\Models\ConfigDepot;

class InvestissementPaiementController extends Controller
{
    public function index($invest)
    {
        $config = ConfigDepot::where('id',1)->first();
        if (!$config) {
            return redirect()->back()->withErrors('Les numéros de dépôt sont absents : le problème est que l\'administrateur ne les a pas encore définis.');
        }

        $investissement = Investissement::FindOrFail($invest);
        return view('investissements.paiement',compact('investissement','config'));
    }
    // Page d’attente "Votre paiement a bien été envoyé"
    public function attente($id)
    {
        $investissement = Investissement::findOrFail($id);
        return view('investissements.attente', [
            'paymentId' => $investissement->id,
            'investissement' => $investissement
        ]);
    }

    // API REST pour checker le statut
    public function apiStatus($id, Request $request)
    {
        $investissement = Investissement::find($id);
        if (!$investissement) {
            return response()->json(['status' => 'failed'], 404);
        }

        switch ($investissement->statut) {
            case 'validé':
            case 'valide':
                return response()->json(['status' => 'validated']);
            case 'rejete':
            case 'rejeté':
                return response()->json(['status' => 'failed']);
            default:
                return response()->json(['status' => 'pending']);
        }
    }

    // Page de "Succès"
    public function success(Request $request)
    {
        $paymentId = $request->query('payment_id');
        $investissement = $paymentId ? \App\Models\Investissement::find($paymentId) : null;
        return view('investissements.success', compact('investissement'));
    }

    // Page d’échec
    public function failed(Request $request)
    {
        $paymentId = $request->query('payment_id');
        $investissement = $paymentId ? \App\Models\Investissement::find($paymentId) : null;
        return view('investissements.failed', compact('investissement'));
    }

    // Statut manuel (optionnel)
    public function status($id)
    {
        $investissement = \App\Models\Investissement::findOrFail($id);
        return view('investissements.status', compact('investissement'));
    }
}
