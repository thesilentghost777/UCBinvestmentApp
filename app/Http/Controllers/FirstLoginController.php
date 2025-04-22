
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class FirstLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();

        // Si l'utilisateur a déjà réclamé son bonus, le rediriger vers le tableau de bord
        if ($user->bonus_reclame) {
            return redirect()->route('dashboard');
        }

        // Marquer le bonus comme réclamé
        $user->bonus_reclame = true;
        $user->save();

        // Créer une transaction pour le bonus d'inscription
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'bonus_inscription',
            'montant' => $user->bonus_inscription,
            'date_transaction' => now(),
            'description' => 'Bonus d\'inscription'
        ]);

        return view('auth.first-login');
    }
}
