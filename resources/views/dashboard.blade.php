@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Bienvenue, {{ auth()->user()->name }}</h1>

    <!-- Vue d'ensemble -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Solde actuel</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format(auth()->user()->solde_actuel, 0, ',', ' ') }} XAF</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Investissements actifs</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ auth()->user()->investissements()->where('statut', 'validé')->count() }}</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Filleuls recrutés</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ auth()->user()->filleuls()->count() }}</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="bg-white rounded-lg shadow-md mb-8">
        <div class="border-b p-6">
            <h2 class="text-lg font-semibold">Actions rapides</h2>
        </div>
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('investissements.index') }}" class="bg-blue-50 hover:bg-blue-100 p-4 rounded-lg text-center transition-colors">
                <div class="h-12 w-12 rounded-full bg-blue-100 mx-auto flex items-center justify-center text-blue-600 mb-4">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <h3 class="font-medium">Investir</h3>
            </a>

            <a href="{{ route('taches.index') }}" class="bg-green-50 hover:bg-green-100 p-4 rounded-lg text-center transition-colors">
                <div class="h-12 w-12 rounded-full bg-green-100 mx-auto flex items-center justify-center text-green-600 mb-4">
                    <i class="fas fa-tasks"></i>
                </div>
                <h3 class="font-medium">Mes tâches</h3>
            </a>

            <a href="{{ route('retraits.index') }}" class="bg-purple-50 hover:bg-purple-100 p-4 rounded-lg text-center transition-colors">
                <div class="h-12 w-12 rounded-full bg-purple-100 mx-auto flex items-center justify-center text-purple-600 mb-4">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h3 class="font-medium">Retirer</h3>
            </a>

            <a href="{{ route('parrainages.index') }}" class="bg-yellow-50 hover:bg-yellow-100 p-4 rounded-lg text-center transition-colors">
                <div class="h-12 w-12 rounded-full bg-yellow-100 mx-auto flex items-center justify-center text-yellow-600 mb-4">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3 class="font-medium">Parrainer</h3>
            </a>
        </div>
    </div>

    <!-- Tâches du jour et investissements -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md">
                <div class="border-b p-6 flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Mes tâches du jour</h2>
                    <a href="{{ route('taches.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Voir tout</a>
                </div>
                <div class="p-6">
                    @php
                        $tachesJournalieres = auth()->user()->tachesJournalieres()
                            ->whereDate('date_attribution', now())
                            ->with('tache')
                            ->take(4)
                            ->get();
                    @endphp

                    @if($tachesJournalieres->count() > 0)
                        <div class="space-y-4">
                            @foreach($tachesJournalieres as $tacheJournaliere)
                                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                                    <div class="flex items-center">
                                        @if($tacheJournaliere->tache->type == 'youtube')
                                            <div class="h-10 w-10 rounded bg-red-100 flex items-center justify-center text-red-600 mr-4">
                                                <i class="fab fa-youtube"></i>
                                            </div>
                                        @elseif($tacheJournaliere->tache->type == 'tiktok')
                                            <div class="h-10 w-10 rounded bg-black flex items-center justify-center text-white mr-4">
                                                <i class="fab fa-tiktok"></i>
                                            </div>
                                        @else
                                            <div class="h-10 w-10 rounded bg-blue-100 flex items-center justify-center text-blue-600 mr-4">
                                                <i class="fas fa-globe"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium">{{ $tacheJournaliere->tache->description }}</p>
                                            <p class="text-sm text-gray-500">
                                                Rémunération: {{ number_format($tacheJournaliere->remuneration, 0, ',', ' ') }} XAF
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        @if($tacheJournaliere->statut == 'completée')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i> Complété
                                            </span>
                                        @elseif($tacheJournaliere->statut == 'expirée')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times mr-1"></i> Expirée
                                            </span>
                                        @else
                                            <a href="{{ route('taches.index', $tacheJournaliere->id) }}" class="bg-blue-600 text-white py-1 px-3 rounded text-sm hover:bg-blue-700 transition-colors">
                                                Effectuer
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-info-circle mr-1"></i>
                                Complétez les tâches quotidiennes pour maximiser vos gains.
                            </p>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="h-16 w-16 rounded-full bg-yellow-100 mx-auto flex items-center justify-center text-yellow-600 mb-4">
                                <i class="fas fa-exclamation-triangle text-xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-800 mb-2">Aucune tâche disponible</h3>
                            <p class="text-gray-600 mb-4">Vous n'avez pas d'investissement actif ou vous avez déjà complété toutes vos tâches aujourd'hui.</p>
                            <a href="{{ route('investissements.index') }}" class="inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors">
                                Investir maintenant
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow-md">
                <div class="border-b p-6 flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Mes investissements</h2>
                    <a href="{{ route('investissements.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Voir tout</a>
                </div>
                <div class="p-6">
                    @php
                        $investissements = auth()->user()->investissements()
                            ->with('package')
                            ->latest('created_at')
                            ->take(3)
                            ->get();
                    @endphp

                    @if($investissements->count() > 0)
                        <div class="space-y-4">
                            @foreach($investissements as $investissement)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <h3 class="font-medium">{{ $investissement->package->nom }}</h3>
                                        @if($investissement->statut == 'en_attente')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                En attente
                                            </span>
                                        @elseif($investissement->statut == 'valide')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Actif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Terminé
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-500 mb-2">Montant: {{ number_format($investissement->montant, 0, ',', ' ') }} XAF</p>
                                    <p class="text-sm text-gray-500">Date: {{ $investissement->date_initiation->format('d/m/Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6">
                            <p class="text-gray-600 mb-4">Vous n'avez pas encore d'investissement.</p>
                            <a href="{{ route('investissements.index') }}" class="inline-block bg-blue-600 text-white py-1 px-4 rounded text-sm hover:bg-blue-700 transition-colors">
                                Investir maintenant
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
