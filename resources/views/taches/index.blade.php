@extends('layouts.app')

@section('title', 'Mes tâches')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mes tâches quotidiennes</h1>
        <p class="text-gray-600">Complétez vos tâches quotidiennes pour maximiser vos gains.</p>
    </div>

    <!-- Vue d'ensemble -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Tâches complétées aujourd'hui</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $tachesCompletees }}/{{ $nombre_tache_j }}</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Tâches restantes</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $nombre_tache_j - $tachesCompletees }}</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fas fa-list"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Gain potentiel aujourd'hui</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($gainPotentiel, 0, ',', ' ') }} XAF</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Jours d'activité consécutifs</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $joursConsecutifs }}</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tâches du jour -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="border-b p-6">
            <h2 class="text-lg font-semibold">Tâches du jour</h2>
            <p class="text-gray-600 text-sm">{{ now()->format('d/m/Y') }}</p>
        </div>

        @if($tachesJournalieres->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($tachesJournalieres as $tache)
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex items-start mb-4 md:mb-0">
                                @if($tache->tache->type == 'youtube')
                                    <div class="h-12 w-12 rounded bg-red-100 flex items-center justify-center text-red-600 mr-4">
                                        <i class="fab fa-youtube text-xl"></i>
                                    </div>
                                @elseif($tache->tache->type == 'tiktok')
                                    <div class="h-12 w-12 rounded bg-black flex items-center justify-center text-white mr-4">
                                        <i class="fab fa-tiktok text-xl"></i>
                                    </div>
                                @else
                                    <div class="h-12 w-12 rounded bg-blue-100 flex items-center justify-center text-blue-600 mr-4">
                                        <i class="fas fa-globe text-xl"></i>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-medium text-gray-900">{{ $tache->tache->description }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">Rémunération: {{ number_format($tache->remuneration, 0, ',', ' ') }} XAF</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                @if($tache->statut == 'completée')
                                    <div class="flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm">
                                        <i class="fas fa-check mr-2"></i>
                                        <span>Tâche complétée</span>
                                    </div>
                                @elseif($tache->statut == 'expirée')
                                    <div class="flex items-center px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm">
                                        <i class="fas fa-times mr-2"></i>
                                        <span>Tâche expirée</span>
                                    </div>
                                @else
                                    <a href="{{ route('taches.show', $tache->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                                        Réaliser cette tâche
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center">
                <div class="h-16 w-16 rounded-full bg-yellow-100 mx-auto flex items-center justify-center text-yellow-600 mb-4">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
                <div class="p-8 text-center">

                    <h3 class="text-lg font-medium text-gray-800 mb-2">Aucune tâche disponible</h3>
                    @php
                        $firstInvestment = auth()->user()->investissements()
                            ->where('statut', 'valide')
                            ->orderBy('date_initiation', 'asc')
                            ->first();
                    @endphp
                    @if(!$firstInvestment)
                        <p class="text-gray-600 mb-4">Vous n'avez pas d'investissement actif. Investissez dans un package pour recevoir des tâches.</p>
                        <a href="{{ route('investissements.create') }}" class="inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors">
                            Investir maintenant
                        </a>
                    @elseif($firstInvestment->date_initiation->diffInHours(now()) < 24)
                        <p class="text-gray-600">Vos tâches seront disponibles à partir de {{ $firstInvestment->date_initiation->format('H:i') }}.</p>
                    @else
                        @if($nombre_tache_j2 > 0)
                        <p class="text-gray-600">Vous avez déjà complété toutes vos tâches d'aujourd'hui. Revenez demain pour de nouvelles tâches.</p>
                        @else
                        <p class="text-gray-600">Vous n'avez pas de tâches disponibles actuellement. Veuillez patienter.</p>
                        @endif
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection