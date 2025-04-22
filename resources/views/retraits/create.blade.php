@extends('layouts.app')

@section('title', 'Demande de retrait')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Demande de retrait</h1>
        <p class="text-gray-600">Retirez vos gains sur votre compte mobile money.</p>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex items-center mb-6">
                <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-4">
                    <i class="fas fa-wallet text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-600">Solde disponible</p>
                    <p class="text-2xl font-bold">{{ number_format(auth()->user()->solde_actuel, 0, ',', ' ') }} XAF</p>
                </div>
            </div>

            @php
                $montantMinimumRetrait = 3250; // Montant minimum de retrait fixé à 3000 XAF
                $fraisRetrait = 0.07; // Frais de retrait de 7%
            @endphp

            @if(auth()->user()->solde_actuel < $montantMinimumRetrait)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-yellow-600 mr-3"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-yellow-800 mb-1">Solde insuffisant</h4>
                            <p class="text-yellow-700 text-sm">Le montant minimum de retrait est de {{ number_format($montantMinimumRetrait, 0, ',', ' ') }} XAF. Continuez à compléter vos tâches quotidiennes pour augmenter votre solde.</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('retraits.index') }}" class="bg-gray-200 text-gray-800 py-2 px-4 rounded hover:bg-gray-300 transition-colors">
                        Retour
                    </a>
                </div>
            @else
                <form action="{{ route('retraits.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="montant" class="block text-sm font-medium text-gray-700 mb-1">Montant à retirer</label>
                        <div class="mt-1 relative">
                            <input type="number" name="montant" id="montant" min="{{ $montantMinimumRetrait }}" max="{{ auth()->user()->solde_actuel }}" step="1" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-3 pr-16" value="{{ old('montant', $montantMinimumRetrait) }}">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">XAF</span>
                            </div>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Minimum: {{ number_format($montantMinimumRetrait, 0, ',', ' ') }} XAF</p>
                        @error('montant')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="montant-apres-frais" class="bg-gray-50 border border-gray-200 rounded-lg p-4 my-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-calculator text-gray-600 mr-3"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 mb-1">Calcul des frais (7%)</h4>
                                <p class="text-gray-700 text-sm">Frais de retrait: <span id="frais-montant">{{ number_format(old('montant', $montantMinimumRetrait) * $fraisRetrait, 0, ',', ' ') }}</span> XAF</p>
                                <p class="text-gray-700 font-medium mt-1">Montant réel à recevoir: <span id="montant-reel">{{ number_format(old('montant', $montantMinimumRetrait) * (1 - $fraisRetrait), 0, ',', ' ') }}</span> XAF</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="numero_reception" class="block text-sm font-medium text-gray-700 mb-1">Numéro de téléphone pour le retrait</label>
                        <input type="text" name="numero_reception" id="numero_reception" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" value="{{ old('numero_reception', auth()->user()->numero_telephone) }}">
                        <p class="mt-1 text-sm text-gray-500">Numéro sur lequel vous souhaitez recevoir votre argent.</p>
                        @error('numero_reception')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-blue-800 mb-1">Information</h4>
                                <p class="text-blue-700 text-sm">Les demandes de retrait sont traitées dans un délai de 24 à 48 heures ouvrables. Vous recevrez une notification une fois votre retrait validé.</p>
                                <p class="text-blue-700 text-sm mt-1">Des frais de retrait de 7% sont appliqués sur tous les retraits.</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-4 flex justify-between">
                        <a href="{{ route('retraits.index') }}" class="bg-gray-200 text-gray-800 py-2 px-4 rounded hover:bg-gray-300 transition-colors">
                            Annuler
                        </a>
                        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors">
                            Demander le retrait
                        </button>
                    </div>
                </form>

                <script>
                    document.getElementById('montant').addEventListener('input', function() {
                        const montant = parseFloat(this.value) || 0;
                        const fraisRetrait = {{ $fraisRetrait }};

                        const fraisMontant = montant * fraisRetrait;
                        const montantReel = montant - fraisMontant;

                        document.getElementById('frais-montant').textContent = new Intl.NumberFormat('fr-FR').format(fraisMontant);
                        document.getElementById('montant-reel').textContent = new Intl.NumberFormat('fr-FR').format(montantReel);
                    });
                </script>
            @endif
        </div>
    </div>
</div>
@endsection