<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Investissement;
use App\Models\TacheJournaliere;
use App\Models\Parrainage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function index()
    {
        $users = User::where('id', '!=', 1) // Exclure l'administrateur
            ->withCount(['investissements', 'tachesJournalieres', 'filleuls'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        if ($user->id === 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas consulter le profil administrateur');
        }

        $user->load([
            'investissements.package',
            'parrainagesEnTantQueParrain.filleul',
            'parrainageEnTantQueFilleul.parrain',
            'retraits'
        ]);

        $stats = [
            'total_invested' => $user->investissements()->where('statut', 'validé')->sum('montant'),
            'total_tasks_completed' => $user->tachesJournalieres()->where('statut', 'completée')->count(),
            'total_earnings' => $user->tachesJournalieres()->where('statut', 'completée')->sum('remuneration'),
            'total_withdrawals' => $user->retraits()->where('statut', 'validé')->sum('montant'),
            'active_packages' => $user->investissements()->where('statut', 'validé')->count(),
            'referrals_count' => $user->filleuls()->count(),
            'active_referrals' => $user->parrainagesEnTantQueParrain()->where('statut_filleul', true)->count(),
            'referral_earnings' => $user->parrainagesEnTantQueParrain()->where('bonus_verse', true)->sum('bonus_obtenu')
        ];

        return view('admin.users.show', compact('user', 'stats'));
    }

    public function edit(User $user)
    {
        if ($user->id === 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas modifier le profil administrateur');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->id === 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas modifier le profil administrateur');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'numero_telephone' => 'required|string|max:20|unique:users,numero_telephone,' . $user->id,
            'solde_actuel' => 'required|numeric|min:0',
            'statut' => 'boolean'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'numero_telephone' => $request->numero_telephone,
            'solde_actuel' => $request->solde_actuel,
            'statut' => $request->has('statut')
        ]);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function resetPassword(Request $request, User $user)
    {
        if ($user->id === 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas réinitialiser le mot de passe administrateur');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'Mot de passe réinitialisé avec succès');
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas modifier le statut de l\'administrateur');
        }

        $user->update([
            'statut' => !$user->statut
        ]);

        $status = $user->statut ? 'activé' : 'désactivé';

        return redirect()->route('admin.users.index')
            ->with('success', "Utilisateur {$status} avec succès");
    }

    public function referrals(User $user)
    {
        if ($user->id === 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas consulter les filleuls de l\'administrateur');
        }

        $referrals = Parrainage::with('filleul')
            ->where('parrain_id', $user->id)
            ->paginate(15);

        $stats = [
            'total_referrals' => Parrainage::where('parrain_id', $user->id)->count(),
            'active_referrals' => Parrainage::where('parrain_id', $user->id)->where('statut_filleul', true)->count(),
            'total_bonus' => Parrainage::where('parrain_id', $user->id)->where('bonus_verse', true)->sum('bonus_obtenu')
        ];

        return view('admin.users.referrals', compact('user', 'referrals', 'stats'));
    }
}
