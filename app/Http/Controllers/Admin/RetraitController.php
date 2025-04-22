<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Retrait;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RetraitController extends Controller
{

    public function index()
    {
        $retraits = Retrait::with('user')
            ->orderBy('date_demande', 'desc')
            ->paginate(15);

        $stats = [
            'total' => Retrait::count(),
            'pending' => Retrait::where('statut', 'en_attente')->count(),
            'validated' => Retrait::where('statut', 'validé')->count(),
            'total_amount' => Retrait::where('statut', 'validé')->sum('montant')
        ];

        return view('admin.retraits.index', compact('retraits', 'stats'));
    }

    public function pending()
    {
        $retraits = Retrait::with('user')
            ->where('statut', 'en_attente')
            ->orderBy('date_demande', 'asc')
            ->paginate(15);

        return view('admin.retraits.pending', compact('retraits'));
    }

    public function validate(Request $request, Retrait $retrait)
    {
        $request->validate([
            'numero_reception' => 'required|string|max:20',
        ]);

        if ($retrait->statut !== 'en_attente') {
            return redirect()->route('admin.retraits.pending')
                ->with('error', 'Ce retrait ne peut pas être validé');
        }

        DB::beginTransaction();

        try {
            // Mettre à jour le retrait
            $retrait->update([
                'date_validation' => Carbon::now(),
                'numero_reception' => $request->numero_reception,
                'statut' => 'validé'
            ]);

            // Enregistrer la transaction
            Transaction::create([
                'user_id' => $retrait->user_id,
                'type' => 'retrait',
                'montant' => -$retrait->montant, // Montant négatif car c'est une sortie d'argent
                'description' => "Validation du retrait #{$retrait->id}"
            ]);

            DB::commit();

            return redirect()->route('admin.retraits.pending')
                ->with('success', 'Retrait validé avec succès');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.retraits.pending')
                ->with('error', "Une erreur est survenue: {$e->getMessage()}");
        }
    }

    public function reject(Retrait $retrait)
    {
        if ($retrait->statut !== 'en_attente') {
            return redirect()->route('admin.retraits.pending')
                ->with('error', 'Ce retrait ne peut pas être rejeté');
        }

        DB::beginTransaction();

        try {
            // Récupérer l'utilisateur et restaurer son solde
            $user = User::find($retrait->user_id);
            $user->update([
                'solde_actuel' => $user->solde_actuel + $retrait->montant
            ]);

            // Supprimer le retrait
            $retrait->delete();


            DB::commit();

            return redirect()->route('admin.retraits.pending')
                ->with('success', 'Retrait rejeté et solde restauré avec succès');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.retraits.pending')
                ->with('error', "Une erreur est survenue: {$e->getMessage()}");
        }
    }

    public function show(Retrait $retrait)
    {
        $retrait->load('user');

        return view('admin.retraits.show', compact('retrait'));
    }

    public function statistics()
    {
        // Statistiques générales
        $stats = [
            'total_amount' => Retrait::where('statut', 'validé')->sum('montant'),
            'total_count' => Retrait::where('statut', 'validé')->count(),
            'avg_amount' => Retrait::where('statut', 'validé')->avg('montant') ?? 0,
            'today_count' => Retrait::whereDate('date_validation', Carbon::today())->count(),
            'today_amount' => Retrait::whereDate('date_validation', Carbon::today())->sum('montant')
        ];

        // Montant des retraits par jour (30 derniers jours)
        $withdrawalsByDay = DB::table('retraits')
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

        $dailyData = $dailyLabels->map(function($day) use ($withdrawalsByDay) {
            $formattedDay = Carbon::createFromFormat('d/m', $day)->format('Y-m-d');
            $record = $withdrawalsByDay->firstWhere('day', $formattedDay);
            return $record ? $record->total : 0;
        });

        return view('admin.retraits.statistics', compact('stats', 'dailyLabels', 'dailyData'));
    }
}
