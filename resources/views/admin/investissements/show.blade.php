@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.investissements.index') }}" class="mr-4 text-blue-600 hover:text-blue-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold">Détails de l'investissement</h1>
    </div>

    <!-- Informations de l'investissement -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold mb-4">Informations générales</h3>
                <div class="space-y-3">
                    <p><span class="font-medium">Package:</span> {{ $investissement->package->nom }}</p>
                    <p><span class="font-medium">Montant:</span> {{ number_format($investissement->montant, 0, ',', ' ') }} FCFA</p>
                    <p><span class="font-medium">Date d'initiation:</span> {{ $investissement->date_initiation->format('d/m/Y H:i') }}</p>
                    @if($investissement->date_validation)
                        <p><span class="font-medium">Date de validation:</span> {{ $investissement->date_validation->format('d/m/Y H:i') }}</p>
                    @endif
                    <p><span class="font-medium">Statut:</span>
                        <span class="px-2 py-1 text-xs rounded-full
                            @switch($investissement->statut)
                                @case('en_attente')
                                    bg-yellow-100 text-yellow-800
                                    @break
                                @case('validé')
                                    bg-green-100 text-green-800
                                    @break
                                @case('terminé')
                                    bg-blue-100 text-blue-800
                                    @break
                            @endswitch
                        ">
                            {{ ucfirst($investissement->statut) }}
                        </span>
                    </p>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Informations utilisateur</h3>
                <div class="space-y-3">
                    <p><span class="font-medium">Nom:</span> {{ $investissement->user->name }}</p>
                    <p><span class="font-medium">Email:</span> {{ $investissement->user->email }}</p>
                    <p><span class="font-medium">Téléphone:</span> {{ $investissement->user->phone ?? 'Non renseigné' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des tâches journalières -->
    <h2 class="text-xl font-semibold mb-4">Tâches attribuées</h2>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tâche</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rémunération</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($investissement->tachesJournalieres as $tache)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ $tache->date_attribution->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $tache->tache->type }}</div>
                            <div class="text-xs text-gray-500">{{ Str::limit($tache->tache->description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $tache->statut === 'completée' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($tache->statut) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{ number_format($tache->remuneration, 0, ',', ' ') }} FCFA
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Aucune tâche attribuée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
