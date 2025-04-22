<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investissement;
use App\Models\Package;
use App\Models\User;
use App\Models\Parrainage;
use App\Models\Transaction;
use App\Models\Tache;
use App\Models\TacheJournaliere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvestissementController extends Controller
{


    public function index()
    {
        $investissements = Investissement::with(['user', 'package'])
            ->orderBy('date_initiation', 'desc')
            ->paginate(15);

        $stats = [
            'total' => Investissement::count(),
            'pending' => Investissement::where('statut', 'en_attente')->count(),
            'validated' => Investissement::where('statut', 'validé')->count(),
            'completed' => Investissement::where('statut', 'terminé')->count(),
            'total_amount' => Investissement::where('statut', 'validé')->sum('montant')
        ];

        return view('admin.investissements.index', compact('investissements', 'stats'));
    }

    public function pending()
    {
        $investissements = Investissement::with(['user', 'package'])
            ->where('statut', 'en_attente')
            ->orderBy('date_initiation', 'asc')
            ->paginate(15);

        return view('admin.investissements.pending', compact('investissements'));
    }

    public function validate(Request $request, Investissement $investissement)
    {
        if ($investissement->statut !== 'en_attente') {
            return redirect()->route('admin.investissements.pending')
                ->with('error', 'Cet investissement ne peut pas être validé');
        }

        DB::beginTransaction();

        try {
            // Mettre à jour l'investissement
            $investissement->update([
                'date_validation' => Carbon::now('UTC')->toDateString(),
                'statut' => 'validé'
            ]);

            // Enregistrer la transaction
            Transaction::create([
                'user_id' => $investissement->user_id,
                'type' => 'investissement',
                'montant' => $investissement->montant,
                'description' => "Validation de l'investissement {$investissement->package->nom}"
            ]);

            // Vérifier si c'est le premier investissement validé de l'utilisateur
            $isFirstInvestment = Investissement::where('user_id', $investissement->user_id)
                ->where('statut', 'validé')
                ->count() === 1;

            // Vérifier le parrainage et attribuer le bonus si c'est le premier investissement
            if ($isFirstInvestment) {
                $user = User::find($investissement->user_id);

                if ($user->id_parrain) {
                    $parrain = User::find($user->id_parrain);
                    $bonusAmount = $investissement->montant * 0.1; // 10% du montant investi

                    // Mise à jour du solde du parrain
                    $parrain->update([
                        'solde_actuel' => $parrain->solde_actuel + $bonusAmount
                    ]);

                    // Enregistrer le bonus dans les transactions
                    Transaction::create([
                        'user_id' => $parrain->id,
                        'type' => 'bonus_parrainage',
                        'montant' => $bonusAmount,
                        'description' => "Bonus de parrainage pour l'investissement de {$user->name}"
                    ]);

                    // Mise à jour du statut du filleul dans le parrainage
                    Parrainage::where('filleul_id', $user->id)
                        ->where('parrain_id', $parrain->id)
                        ->update([
                            'bonus_obtenu' => $bonusAmount,
                            'bonus_verse' => true,
                            'statut_filleul' => true
                        ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.investissements.pending')
                ->with('success', 'Investissement validé avec succès');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.investissements.pending')
                ->with('error', "Une erreur est survenue: {$e->getMessage()}");
        }
    }

    public function reject(Investissement $investissement)
    {
        if ($investissement->statut !== 'en_attente') {
            return redirect()->route('admin.investissements.pending')
                ->with('error', 'Cet investissement ne peut pas être rejeté');
        }

        $investissement->delete();

        return redirect()->route('admin.investissements.pending')
            ->with('success', 'Investissement rejeté avec succès');
    }

    public function show(Investissement $investissement)
    {
        $investissement->load(['user', 'package', 'tachesJournalieres']);

        return view('admin.investissements.show', compact('investissement'));
    }

    public function statistics()
    {
        // Statistiques générales
        $stats = [
            'total_amount' => Investissement::where('statut', 'validé')->sum('montant'),
            'total_count' => Investissement::where('statut', 'validé')->count(),
            'avg_amount' => Investissement::where('statut', 'validé')->avg('montant') ?? 0,
            'today_count' => Investissement::whereDate('date_validation', Carbon::today())->count(),
            'today_amount' => Investissement::whereDate('date_validation', Carbon::today())->sum('montant')
        ];

        // Montant total des investissements par package
        $packageDistribution = Package::withCount(['investissements' => function($query) {
            $query->where('statut', 'validé');
        }])->withSum(['investissements' => function($query) {
            $query->where('statut', 'validé');
        }], 'montant')->get();

        // Investissements par jour (30 derniers jours)
        $investmentsByDay = DB::table('investissements')
            ->select(DB::raw('DATE(date_validation) as day'), DB::raw('SUM(montant) as total'))
            ->where('statut', 'validé')
            ->whereNotNull('date_validation')
            ->whereBetween('date_validation', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $dailyLabels = collect(range(30, 0))->map(function($days) {
            return Carbon::now()->subDays($days)->format('d/m');
        });

        $dailyData = $dailyLabels->map(function($day) use ($investmentsByDay) {
            $formattedDay = Carbon::createFromFormat('d/m', $day)->format('Y-m-d');
            $record = $investmentsByDay->firstWhere('day', $formattedDay);
            return $record ? $record->total : 0;
        });

        return view('admin.investissements.statistics', compact('stats', 'packageDistribution', 'dailyLabels', 'dailyData'));
    }
}
