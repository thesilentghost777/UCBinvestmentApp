<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tache;
use App\Models\TacheJournaliere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TacheController extends Controller
{


    public function index()
    {
        $taches = Tache::withCount([
            'tachesJournalieres',
            'tachesJournalieres as completed_count' => function($query) {
                $query->where('statut', 'completée');
            }
        ])->get();

        return view('admin.taches.index', compact('taches'));
    }

    public function create()
    {
        return view('admin.taches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:youtube,tiktok,facebook,instagram,autre',
            'lien' => 'required|url',
            'description' => 'required|string|max:500'
        ]);

        Tache::create([
            'type' => $request->type,
            'lien' => $request->lien,
            'description' => $request->description,
            'statut' => true
        ]);

        return redirect()->route('admin.taches.index')
            ->with('success', 'Tâche créée avec succès');
    }

    public function edit(Tache $tache)
    {
        return view('admin.taches.edit', compact('tache'));
    }

    public function update(Request $request, Tache $tache)
    {
        $request->validate([
            'type' => 'required|in:youtube,tiktok,facebook,instagram,autre',
            'lien' => 'required|url',
            'description' => 'required|string|max:500',
        ]);

        $tache->update([
            'type' => $request->type,
            'lien' => $request->lien,
            'description' => $request->description,
            'statut' => true
        ]);

        return redirect()->route('admin.taches.index')
            ->with('success', 'Tâche mise à jour avec succès');
    }

    public function toggleStatus(Tache $tache)
    {
        $tache->update([
            'statut' => !$tache->statut
        ]);

        $status = $tache->statut ? 'activée' : 'désactivée';

        return redirect()->route('admin.taches.index')
            ->with('success', "Tâche {$status} avec succès");
    }

    public function show(Tache $tache)
    {
        $completions = TacheJournaliere::where('tache_id', $tache->id)
            ->with(['user', 'investissement'])
            ->orderBy('date_realisation', 'desc')
            ->paginate(15);

        $stats = [
            'total_assigned' => TacheJournaliere::where('tache_id', $tache->id)->count(),
            'total_completed' => TacheJournaliere::where('tache_id', $tache->id)->where('statut', 'completée')->count(),
            'total_earnings' => TacheJournaliere::where('tache_id', $tache->id)->where('statut', 'completée')->sum('remuneration'),
            'completion_rate' => TacheJournaliere::where('tache_id', $tache->id)->count() > 0
                ? (TacheJournaliere::where('tache_id', $tache->id)->where('statut', 'completée')->count() /
                   TacheJournaliere::where('tache_id', $tache->id)->count() * 100)
                : 0
        ];

        return view('admin.taches.show', compact('tache', 'completions', 'stats'));
    }

    public function statistics()
    {
        // Statistiques générales
        $stats = [
            'total_taches' => Tache::count(),
            'active_taches' => Tache::where('statut', true)->count(),
            'total_attributions' => TacheJournaliere::count(),
            'total_completions' => TacheJournaliere::where('statut', 'completée')->count(),
            'total_earnings' => TacheJournaliere::where('statut', 'completée')->sum('remuneration')
        ];

        // Taux de complétion par type de tâche
        $completionRateByType = DB::table('taches')
            ->select('type',
                DB::raw('COUNT(taches_journalieres.id) as total_assigned'),
                DB::raw('SUM(CASE WHEN taches_journalieres.statut = "completée" THEN 1 ELSE 0 END) as total_completed'))
            ->leftJoin('taches_journalieres', 'taches.id', '=', 'taches_journalieres.tache_id')
            ->groupBy('type')
            ->get()
            ->map(function($item) {
                $item->completion_rate = $item->total_assigned > 0 ? ($item->total_completed / $item->total_assigned * 100) : 0;
                return $item;
            });

        // Complétion par jour
        $completionByDay = DB::table('taches_journalieres')
            ->select(DB::raw('DATE(date_realisation) as day'), DB::raw('COUNT(*) as count'))
            ->where('statut', 'completée')
            ->whereNotNull('date_realisation')
            ->whereBetween('date_realisation', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $dailyLabels = collect(range(30, 0))->map(function($days) {
            return Carbon::now()->subDays($days)->format('d/m');
        });

        $dailyData = $dailyLabels->map(function($day) use ($completionByDay) {
            $formattedDay = Carbon::createFromFormat('d/m', $day)->format('Y-m-d');
            $record = $completionByDay->firstWhere('day', $formattedDay);
            return $record ? $record->count : 0;
        });

        return view('admin.taches.statistics', compact('stats', 'completionRateByType', 'dailyLabels', 'dailyData'));
    }


}