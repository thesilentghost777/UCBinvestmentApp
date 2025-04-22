<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investissement;
use App\Models\User;
use App\Models\Tache;
use App\Models\TacheJournaliere;
use App\Models\Package;
use App\Models\Retrait;
use App\Models\Solde;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{


    public function dashboard()
    {
        $stats = [
            'total_users' => User::where('id', '!=', 1)->count(),
            'active_users' => User::where('statut', true)->where('id', '!=', 1)->count(),
            'total_investments' => Investissement::count(),
            'pending_investments' => Investissement::where('statut', 'en_attente')->count(),
            'completed_tasks' => TacheJournaliere::where('statut', 'completée')->count(),
            'total_withdrawn' => Retrait::where('statut', 'validé')->sum('montant'),
            'pending_withdrawals' => Retrait::where('statut', 'en_attente')->count(),
            'total_packages' => Package::count()
        ];

        $solde = Solde::latest()->first();

        // Données pour le graphique des inscriptions
        $last30Days = collect(range(29, 0))->map(function($days) {
            $date = Carbon::now()->subDays($days)->format('Y-m-d');
            $count = User::whereDate('created_at', $date)->count();
            return [
                'date' => Carbon::now()->subDays($days)->format('d/m'),
                'count' => $count
            ];
        });

        // Données pour le graphique des investissements
        $investmentsData = Package::withCount('investissements')->get()->map(function($package) {
            return [
                'name' => $package->nom,
                'count' => $package->investissements_count
            ];
        });

        return view('admin.dashboard', compact('stats', 'solde', 'last30Days', 'investmentsData'));
    }

    public function soldeForm()
    {
        $solde = Solde::latest()->first();
        $history = Solde::orderBy('created_at', 'desc')->take(10)->get();

        return view('admin.solde', compact('solde', 'history'));
    }

    public function updateSolde(Request $request)
    {
        $request->validate([
            'solde_virtuel' => 'required|numeric|min:0',
            'solde_physique' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:255',
        ]);

        Solde::create([
            'solde_virtuel' => $request->solde_virtuel,
            'solde_physique' => $request->solde_physique,
            'admin_id' => Auth::id(),
            'notes' => $request->notes ?? 'Mise à jour manuelle'
        ]);

        return redirect()->route('admin.solde')
            ->with('success', 'Solde mis à jour avec succès');
    }

    public function profitPrediction()
    {
        $latestSolde = Solde::latest()->first();

        if (!$latestSolde) {
            return view('admin.profit-prediction')->with('error', 'Aucune donnée de solde disponible');
        }

        $pendingWithdrawals = Retrait::where('statut', 'en_attente')->sum('montant');
        $activeInvestments = Investissement::where('statut', 'validé')->sum('montant');

        $projections = collect(range(1, 12))->map(function($month) use ($latestSolde, $pendingWithdrawals, $activeInvestments) {
            // Modèle simple: profit prévu = solde physique - retraits en attente + (investissements actifs * 0.1 * mois)
            $projectedProfit = $latestSolde->solde_physique - $pendingWithdrawals + ($activeInvestments * 0.1 * $month);

            return [
                'month' => Carbon::now()->addMonths($month)->format('M Y'),
                'projected_profit' => $projectedProfit
            ];
        });

        return view('admin.profit-prediction', compact('latestSolde', 'pendingWithdrawals', 'activeInvestments', 'projections'));
    }

    public function userStats()
    {
        $userStats = [
            'total' => User::where('id', '!=', 1)->count(),
            'active' => User::where('statut', true)->where('id', '!=', 1)->count(),
            'registered_today' => User::whereDate('created_at', Carbon::today())->count(),
            'registered_week' => User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'registered_month' => User::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)->count()
        ];

        $users = User::where('id', '!=', 1)
            ->withCount(['investissements', 'tachesJournalieres', 'filleuls'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.user-stats', compact('userStats', 'users'));
    }
}
