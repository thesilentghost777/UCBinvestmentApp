@extends('layouts.app')
@section('content')
<div class="container mx-auto py-8 px-4 max-w-lg">
    <div class="bg-white shadow rounded-lg p-6 md:p-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Paiement du dépôt</h2>
        <div class="mb-4 text-center">
            <span class="text-gray-700">Veuillez payer la somme de</span>
            <div class="font-bold text-xl md:text-2xl text-indigo-700 mt-1">{{ number_format($investissement->montant, 0, ',', ' ') }} FCFA</div>
        </div>
        <div class="mb-6 text-center">
            <span class="text-gray-700">a l'un des numéro suivant :</span>
            <div class="font-mono font-bold text-lg md:text-xl text-blue-800 mt-2 bg-blue-50 py-2 rounded">MOMO: {{ $config->numero_depot_mtn }} : {{ $config->nom_depot_mtn }}</div>
            <div class="font-mono font-bold text-lg md:text-xl text-blue-800 mt-2 bg-blue-50 py-2 rounded">OM: {{ $config->numero_depot_orange }} : {{  $config->nom_depot_orange }}</div>
        </div>
        <form method="POST" action="{{ route('investissements.attente', $investissement->id) }}">
            @csrf

            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium">Numéro de téléphone du payeur</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">+237</span>
                    <input type="tel" name="tel_paiement" required class="w-full border rounded pl-12 py-3 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-600 outline-none transition" maxlength="9" placeholder="Ex: 657777777" pattern="[6-9][0-9]{8}" />
                </div>
                <p class="text-xs text-gray-500 mt-1">Format: 6XXXXXXXX (9 chiffres)</p>
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg transition mb-2 font-medium focus:ring-4 focus:ring-indigo-300">
                Confirmer le paiement
            </button>
        </form>
        <div class="mt-4 text-sm text-gray-500 text-center">
            Après confirmation, patientez le temps que l'administration valide votre dépôt.
        </div>
    </div>
</div>
@endsection