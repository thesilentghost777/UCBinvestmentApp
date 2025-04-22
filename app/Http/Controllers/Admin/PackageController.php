<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Investissement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PackageController extends Controller
{


    public function index()
    {
        $packages = Package::withCount('investissements')->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:packages',
            'montant_investissement' => 'required|numeric|min:0',
            'valeur_par_tache' => 'required|numeric|min:0',
            'gain_journalier' => 'required|numeric|min:0',
        ]);

        Package::create([
            'nom' => $request->nom,
            'montant_investissement' => $request->montant_investissement,
            'bonus_inscription' => $request->bonus_inscription,
            'valeur_par_tache' => $request->valeur_par_tache,
            'gain_journalier' => $request->gain_journalier,
            'actif' => true
        ]);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package créé avec succès');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('packages')->ignore($package->id)
            ],
            'montant_investissement' => 'required|numeric|min:0',
            'valeur_par_tache' => 'required|numeric|min:0',
            'gain_journalier' => 'required|numeric|min:0',
            'actif' => 'boolean'
        ]);

        $package->update([
            'nom' => $request->nom,
            'montant_investissement' => $request->montant_investissement,
            'bonus_inscription' => $request->bonus_inscription,
            'valeur_par_tache' => $request->valeur_par_tache,
            'gain_journalier' => $request->gain_journalier,
            'jours_retour_investissement' => $request->jours_retour_investissement,
            'actif' => $request->has('actif')
        ]);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package mis à jour avec succès');
    }

    public function toggleStatus(Package $package)
    {
        $package->update([
            'actif' => !$package->actif
        ]);

        $status = $package->actif ? 'activé' : 'désactivé';

        return redirect()->route('admin.packages.index')
            ->with('success', "Package {$status} avec succès");
    }

    public function show(Package $package)
    {
        $investissements = Investissement::where('package_id', $package->id)
            ->with('user')
            ->paginate(15);

        return view('admin.packages.show', compact('package', 'investissements'));
    }
}