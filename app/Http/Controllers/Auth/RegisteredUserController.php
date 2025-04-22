<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Parrainage;
use App\Models\Solde;
use App\Services\EthereumService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Str;


class RegisteredUserController extends Controller
{

    /**
     * Affiche le formulaire d'inscription.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Traite l'inscription d'un utilisateur.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'numero_telephone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'code_parrain' => 'nullable|string|exists:users,code_parrainage'
        ]);

        // Générer un code de parrainage unique
        $code_parrainage = Str::random(8);
        while (User::where('code_parrainage', $code_parrainage)->exists()) {
            $code_parrainage = Str::random(8);
        }

        // Trouver le parrain si un code est fourni
        $id_parrain = null;
        if ($request->code_parrain) {
            $parrain = User::where('code_parrainage', $request->code_parrain)->first();
            if ($parrain) {
                $id_parrain = $parrain->id;
            }
        }

        // Créer l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'numero_telephone' => $request->numero_telephone,
            'password' => Hash::make($request->password),
            'code_parrainage' => $code_parrainage,
            'id_parrain' => $id_parrain,
            'bonus_inscription' => 500.00, // Bonus d'inscription de 500 XAF
            'bonus_reclame' => true,
            'solde_actuel' => 500,
            'statut' => true,
            'is_admin' => false
        ]);
        #reduire le solde
            $solde = Solde::first();
            $solde->solde_virtuel = $solde->solde_virtuel-500;
            $solde->save();
        // Créer l'enregistrement de parrainage si nécessaire
        if ($id_parrain) {
            Parrainage::create([
                'parrain_id' => $id_parrain,
                'filleul_id' => $user->id,
                'code_parrainage_utilise' => $request->code_parrain,
                'date_parrainage' => now(),
                'bonus_obtenu' => 0, // Sera mis à jour lors de l'investissement
                'bonus_verse' => false,
                'statut_filleul' => false
            ]);
        }

        auth()->login($user);

        return redirect()->route('dashboard');
    }
}