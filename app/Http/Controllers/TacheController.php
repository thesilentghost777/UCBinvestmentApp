<?php

namespace App\Http\Controllers;

use App\Models\TacheJournaliere;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TacheController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Récupérer les tâches journalières non complétées et non expirées pour aujourd'hui
        $tachesJournalieres = $user->tachesJournalieres()
            ->whereDate('date_attribution', $today)
            ->where('statut', '!=', 'completee')
            ->where('statut', '!=', 'expiree')
            ->with('tache', 'investissement')
            ->get();

        // Calculer le nombre de tâches complétées aujourd'hui
        $tachesCompletees = $user->tachesJournalieres()
            ->whereDate('date_attribution', $today)
            ->where('statut', 'completee')
            ->count();

        // Calculer le gain potentiel
        $gainPotentiel = $tachesJournalieres->sum('remuneration');

        // Calculer le nombre de jours consécutifs avec des tâches complétées
        $joursConsecutifs = $this->calculerJoursConsecutifs($user->id);

        return view('taches.index', compact('tachesJournalieres', 'tachesCompletees', 'gainPotentiel', 'joursConsecutifs'));
    }

    public function show($id)
    {
        $tacheJournaliere = TacheJournaliere::with('tache')->findOrFail($id);

        // Vérifier que l'utilisateur est bien le propriétaire
        if ($tacheJournaliere->user_id !== Auth::id()) {
            return redirect()->route('taches.index')
                ->with('error', 'Vous n\'êtes pas autorisé à accéder à cette tâche.');
        }

        // Vérifier que la tâche n'est pas déjà complétée
        if ($tacheJournaliere->statut === 'completee') {
            return redirect()->route('taches.index')
                ->with('info', 'Cette tâche a déjà été complétée.');
        }

        // Vérifier que la tâche n'est pas expirée
        if ($tacheJournaliere->statut === 'expiree') {
            return redirect()->route('taches.index')
                ->with('error', 'Cette tâche est expirée.');
        }

        return view('taches.show', compact('tacheJournaliere'));
    }


}