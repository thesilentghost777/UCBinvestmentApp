@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.taches.index') }}" class="mr-4 text-blue-600 hover:text-blue-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold">Détails de la tâche</h1>
    </div>

    <!-- Informations de la tâche -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold mb-2">Informations générales</h3>
                <div class="space-y-2">
                    <p><span class="font-medium">Type:</span> {{ ucfirst($tache->type) }}</p>
                    <p><span class="font-medium">Lien:</span>
                        <a href="{{ $tache->lien }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                            {{ $tache->lien }}
                        </a>
                    </p>
                    <p><span class="font-medium">Statut:</span>
                        <span class="px-2 py-1 text-xs rounded-full {{ $tache->statut ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $tache->statut ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">Statistiques</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Total attributions</p>
                        <p class="text-2xl font-semibold">{{ $stats['total_assigned'] }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Complétées</p>
                        <p class="text-2xl font-semibold">{{ $stats['total_completed'] }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Taux de complétion</p>
                        <p class="text-2xl font-semibold">{{ number_format($stats['completion_rate'], 1) }}%</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600">Gains générés</p>
                        <p class="text-2xl font-semibold">{{ number_format($stats['total_earnings'], 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des complétions -->
    <h2 class="text-xl font-semibold mb-4">Historique des réalisations</h2>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Investissement</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rémunération</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($completions as $completion)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $completion->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $completion->date_realisation ? $completion->date_realisation->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $completion->investissement->package->nom }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $completion->statut === 'completée' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($completion->statut) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ number_format($completion->remuneration, 0, ',', ' ') }} FCFA
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Aucune réalisation trouvée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-4">
            {{ $completions->links() }}
        </div>
    </div>
</div>
@endsection
