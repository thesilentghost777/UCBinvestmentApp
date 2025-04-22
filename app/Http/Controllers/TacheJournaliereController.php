<?php

namespace App\Http\Controllers;

use App\Models\TacheJournaliere;
use App\Models\Tache;
use App\Models\Transaction;
use App\Models\User;
use App\Models\SoldeCP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TacheJournaliereController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Récupérer les tâches journalières non complétées et non expirées pour aujourd'hui

    $tachesJournalieres = $user->tachesJournalieres()
        ->whereDate('date_attribution', Carbon::now('UTC')->toDateString())
        ->where('statut','a_faire')
        ->with('tache', 'investissement')
        ->get();


            Log::info("tache journaliere:$tachesJournalieres");
            $tachesJournalieres2 = $user->tachesJournalieres()
            ->whereDate('date_attribution', now())
            ->with('tache', 'investissement')
            ->get();
        $nombre_tache_j = $tachesJournalieres2->count();
        $nombre_tache_j2 = $user->tachesJournalieres()->whereDate('date_attribution', Carbon::now('UTC')->toDateString())->where('statut','completee')->get()->count();

        // Calculer le nombre de tâches complétées aujourd'hui
        $tachesCompletees = $user->tachesJournalieres()
            ->whereDate('date_attribution', now())
            ->where('statut', 'completée')
            ->count();

        // Calculer le gain potentiel
        $gainPotentiel = $tachesJournalieres2->sum('remuneration');

        // Calculer le nombre de jours consécutifs avec des tâches complétées
        $joursConsecutifs = $this->calculerJoursConsecutifs($user->id);

        return view('taches.index', compact('nombre_tache_j','nombre_tache_j2','tachesJournalieres', 'tachesCompletees', 'gainPotentiel', 'joursConsecutifs'));
    }


    public function show(TacheJournaliere $tacheJournaliere)
    {
        // Vérifier que cette tâche appartient bien à l'utilisateur connecté
        if ($tacheJournaliere->user_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette tâche.');
        }

        // Vérifier que la tâche n'a pas déjà été complétée
        if ($tacheJournaliere->statut === 'completée') {
            return redirect()->route('taches.index')
                ->with('info', 'Cette tâche a déjà été complétée.');
        }

        // Vérifier que la tâche est toujours active
        if (!$tacheJournaliere->tache->statut) {
            return redirect()->route('taches.index')
                ->with('error', 'Cette tâche n\'est plus disponible.');
        }

        return view('taches.show', compact('tacheJournaliere'));
    }

    /**
     * Vérifier le temps de visionnage pour les vidéos YouTube/TikTok
     */
    public function verifyWatchTime(Request $request, TacheJournaliere $tacheJournaliere)
    {
        // Vérifier que cette tâche appartient bien à l'utilisateur connecté
        if ($tacheJournaliere->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Non autorisé'], 403);
        }

        // Valider les données de la requête
        $request->validate([
            'watchTime' => 'required|integer|min:1',
            'videoId' => 'required|string',
        ]);

        // Temps minimum requis en secondes
        $requiredTime = 60; // 30 secondes minimum

        if ($request->watchTime >= $requiredTime) {
            // Stocker dans la session que l'utilisateur a regardé cette vidéo
            session()->put('watched_video_' . $tacheJournaliere->id, true);
            return response()->json([
                'success' => true,
                'message' => 'Temps de visionnage vérifié avec succès'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Veuillez regarder la vidéo pendant au moins ' . $requiredTime . ' secondes',
            'required' => $requiredTime,
            'current' => $request->watchTime
        ]);
    }

    /**
     * Marquer une tâche comme complétée et rémunérer l'utilisateur
     */
    public function complete(Request $request, $id)
    {
        $request->validate([
            'confirmation' => 'required',
        ]);

        $tacheJournaliere = TacheJournaliere::with(['tache', 'investissement'])->findOrFail($id);

        // Vérifier que l'utilisateur est bien le propriétaire
        if ($tacheJournaliere->user_id !== Auth::id()) {
            return redirect()->route('taches.index')
                ->with('error', 'Vous n\'êtes pas autorisé à compléter cette tâche.');
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

        // Marquer la tâche comme complétée
        $tacheJournaliere->update([
            'statut' => 'completee',
            'date_realisation' => now()
        ]);

        // Mettre à jour le solde de l'utilisateur
        $user = Auth::user();
        $user->solde_actuel += $tacheJournaliere->remuneration;
        $user->save();

        // Créer une transaction
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'paiement_tache',
            'montant' => $tacheJournaliere->remuneration,
            'date_transaction' => now(),
            'description' => 'Paiement pour tâche complétée - ' . $tacheJournaliere->tache->description
        ]);

        return redirect()->route('taches.index')
            ->with('success', 'Tâche complétée avec succès ! Vous avez gagné ' . number_format($tacheJournaliere->remuneration, 0, ',', ' ') . ' XAF.');
    }

    public function verifyVisitTime(Request $request, TacheJournaliere $tacheJournaliere)
    {
        if ($tacheJournaliere->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Non autorisé'], 403);
        }

        $request->validate([
            'visitTime' => 'required|integer|min:1',
        ]);

        // Temps minimum requis en secondes (1 minute)
        $requiredTime = 60;

        if ($request->visitTime >= $requiredTime) {
            session()->put('visited_link_' . $tacheJournaliere->id, true);
            return response()->json([
                'success' => true,
                'message' => 'Temps de visite vérifié avec succès'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Veuillez rester sur la page pendant au moins 1 minute',
            'required' => $requiredTime,
            'current' => $request->visitTime
        ]);
    }

    private function calculerJoursConsecutifs($userId)
    {
        $joursConsecutifs = 0;
        $date = now();

        while (true) {
            // Vérifier si l'utilisateur a complété des tâches ce jour-là
            $tachesCompletees = TacheJournaliere::where('user_id', $userId)
                ->whereDate('date_realisation', $date)
                ->where('statut', 'completee')
                ->count();

            if ($tachesCompletees > 0) {
                $joursConsecutifs++;
                $date->subDay();
            } else {
                break;
            }
        }

        return $joursConsecutifs;
    }


}
