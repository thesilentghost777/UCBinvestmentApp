<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConfigDepot;
use Illuminate\Http\Request;

class ConfigDepotController extends Controller
{
    // Afficher la config existante, ou un formulaire de création
    public function edit()
    {
        $config = ConfigDepot::first();
        return view('admin.config_depots.edit', compact('config'));
    }

    // Mettre à jour ou créer la config
    public function update(Request $request)
    {
        $request->validate([
            'numero_depot_mtn'     => 'nullable|string|max:30',
            'numero_depot_orange'  => 'nullable|string|max:30',
            'nom_depot_mtn'     => 'nullable|string|max:30',
            'nom_depot_orange'  => 'nullable|string|max:30',
            'lien_video_youtube'   => 'nullable|url|max:255',
            'lien_video_tiktok'    => 'nullable|url|max:255',
            'code_admin'           => 'nullable|string|max:50',
        ]);
        $config = ConfigDepot::first();

        if ($config) {
            $config->update($request->all());
        } else {
            $config = ConfigDepot::create($request->all());
        }
        return redirect()->route('admin.config-depots.edit')->with('success', 'Configuration enregistrée !');
    }

    // Supprimer la config (rare mais demandé)
    public function destroy()
    {
        $config = ConfigDepot::first();
        if ($config) {
            $config->delete();
        }
        return redirect()->route('admin.config-depots.edit')->with('success', 'Configuration supprimée.');
    }
}