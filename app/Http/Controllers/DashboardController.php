<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TacheJournaliere;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        // Si c'est un administrateur, rediriger vers le tableau de bord admin
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        // Si c'est la première connexion de l'utilisateur, le rediriger vers la page de bienvenue
        if (!$user->bonus_reclame) {
            return redirect()->route('first.login');
        }

        return view('dashboard');
    }
}