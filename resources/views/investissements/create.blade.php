@extends('layouts.app')

@section('title', 'Nouvel investissement')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Choisir un package</h1>
        <p class="text-gray-600">Sélectionnez un package d'investissement qui correspond à votre budget.</p>
    </div>

    @php
        $packages = \App\Models\Package::where('actif', true)->get();
    @endphp

    <!-- Packages disponibles -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($packages as $package)
            <div class="bg-white rounded-lg shadow-md overflow-hidden border hover:shadow-lg transition-shadow">
                <div class="bg-blue-600 text-white p-4">
                    <h3 class="text-xl font-bold text-center">{{ $package->nom }}</h3>
                </div>
                <div class="p-6">
                    <div class="text-center mb-6">
                        <span class="text-3xl font-bold text-gray-800">{{ number_format($package->montant_investissement, 0, ',', ' ') }}</span>
                        <span class="text-gray-600"> XAF</span>
                    </div>
                    <ul class="space-y-3 mb-6">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Valeur par tâche: <strong>{{ number_format($package->valeur_par_tache, 0, ',', ' ') }} XAF</strong></span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Gain journalier: <strong>{{ number_format($package->gain_journalier, 0, ',', ' ') }} XAF</strong></span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            <span>Retour sur investissement: <strong>{{ $package->jours_retour_investissement }} jours</strong></span>
                        </li>
                    </ul>
                    <form action="{{ route('investissements.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors">
                            Sélectionner
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Information -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold mb-4">Comment ça fonctionne ?</h2>
        <div class="space-y-4">
            <div class="flex">
                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                    <span class="font-bold">1</span>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800">Choisissez un package</h3>
                    <p class="text-gray-600">Sélectionnez le package qui correspond le mieux à votre budget et à vos objectifs.</p>
                </div>
            </div>

            <div class="flex">
                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                    <span class="font-bold">2</span>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800">Effectuez le paiement</h3>
                    <p class="text-gray-600">Suivez les instructions pour effectuer votre dépôt sur le numéro de téléphone fourni.</p>
                </div>
            </div>

            <div class="flex">
                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                    <span class="font-bold">3</span>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800">Validation et activation</h3>
                    <p class="text-gray-600">Une fois votre paiement confirmé, votre package sera activé et vous pourrez commencer à réaliser des tâches.</p>
                </div>
            </div>

            <div class="flex">
                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                    <span class="font-bold">4</span>
                </div>
                <div>
                    <h3 class="font-medium text-gray-800">Réalisez vos tâches quotidiennes</h3>
                    <p class="text-gray-600">Complétez les 4 tâches quotidiennes pour recevoir votre rémunération journalière.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection