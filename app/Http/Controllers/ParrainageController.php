<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Parrainage;

class ParrainageController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        // Calculer le nombre de filleuls actifs (ceux ayant au moins un investissement validé)
        $filleulsActifs = 0;
        $filleuls = $user->filleuls;

        if ($filleuls) {
            foreach ($filleuls as $filleul) {
                if ($filleul->investissements()->where('statut', 'validé')->count() > 0) {
                    $filleulsActifs++;
                }
            }
        }

        // Calculer les commissions gagnées
        $commissionsGagnees = $user->parrainagesEnTantQueParrain()->sum('bonus_obtenu');

        return view('parrainages.index', compact('filleulsActifs', 'commissionsGagnees'));
    }
}
