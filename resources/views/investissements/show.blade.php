@extends('layouts.app')

@section('title', 'Détails de l\'investissement')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Détails de l'investissement</h1>
        <a href="{{ route('investissements.index') }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-1"></i> Retour à mes investissements
        </a>
    </div>

    <!-- Informations principales -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="bg-blue-600 p-4 text-white">
            <h2 class="text-lg font-semibold">{{ $investissement->package->nom }}</h2>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Statut</h3>
                    @if($investissement->statut == 'en_attente')
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 mr-2">
                                En attente
                            </span>
                            <span class="text-gray-500 text-sm">En attente de validation</span>
                        </div>
                    @elseif($investissement->statut == 'valide')
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-2">
                                Actif
                            </span>
                            <span class="text-gray-500 text-sm">Validé le {{ $investissement->date_validation ? $investissement->date_validation->format('d/m/Y') : 'N/A' }}</span>
                        </div>
                    @else
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mr-2">
                                Terminé
                            </span>
                            <span class="text-gray-500 text-sm">Investissement terminé</span>
                        </div>
                    @endif
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Date d'initiation</h3>
                    <p class="font-medium">{{ $investissement->date_initiation->format('d/m/Y H:i') }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Montant investi</h3>
                    <p class="font-medium">{{ number_format($investissement->montant, 0, ',', ' ') }} XAF</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-1">Numéro de dépôt</h3>
                    <p class="font-medium">{{ $investissement->numero_depot }}</p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t">
                <h3 class="font-medium mb-3">Détails du package</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h4 class="text-sm text-gray-500 mb-1">Valeur par tâche</h4>
                        <p>{{ number_format($investissement->package->valeur_par_tache, 0, ',', ' ') }} XAF</p>
                    </div>

                    <div>
                        <h4 class="text-sm text-gray-500 mb-1">Gain journalier</h4>
                        <p>{{ number_format($investissement->package->gain_journalier, 0, ',', ' ') }} XAF</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Tâches associées -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold">Tâches associées</h2>
        </div>

        @php
            $tachesJournalieres = $investissement->tachesJournalieres()->with('tache')->latest('date_attribution')->paginate(10);
        @endphp

        @if($tachesJournalieres->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tâche</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rémunération</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tachesJournalieres as $tacheJournaliere)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($tacheJournaliere->tache->type == 'youtube')
                                            <div class="h-8 w-8 rounded bg-red-100 flex items-center justify-center text-red-600 mr-4">
                                                <i class="fab fa-youtube"></i>
                                            </div>
                                        @elseif($tacheJournaliere->tache->type == 'tiktok')
                                            <div class="h-8 w-8 rounded bg-black flex items-center justify-center text-white mr-4">
                                                <i class="fab fa-tiktok"></i>
                                            </div>
                                        @else
                                            <div class="h-8 w-8 rounded bg-blue-100 flex items-center justify-center text-blue-600 mr-4">
                                                <i class="fas fa-globe"></i>
                                            </div>
                                        @endif
                                        <span>{{ $tacheJournaliere->tache->description }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $tacheJournaliere->date_attribution->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ number_format($tacheJournaliere->remuneration, 0, ',', ' ') }} XAF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($tacheJournaliere->statut == 'completée')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i> Complétée
                                        </span>
                                    @elseif($tacheJournaliere->statut == 'expirée')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times mr-1"></i> Expirée
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i> À faire
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t">
                {{ $tachesJournalieres->links() }}
            </div>
        @else
            <div class="p-6 text-center">
                <div class="h-16 w-16 rounded-full bg-yellow-100 mx-auto flex items-center justify-center text-yellow-600 mb-4">
                    <i class="fas fa-tasks text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-1">Aucune tâche disponible</h3>
                @if($investissement->statut == 'en_attente')
                    <p class="text-gray-600">Les tâches seront disponibles une fois votre investissement validé.</p>
                @else
                    <p class="text-gray-600">Aucune tâche n'est associée à cet investissement pour le moment.</p>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
