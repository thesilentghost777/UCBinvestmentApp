@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Gestion des investissements</h1>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Total</h3>
            <p class="text-2xl font-semibold">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">En attente</h3>
            <p class="text-2xl font-semibold text-yellow-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Validés</h3>
            <p class="text-2xl font-semibold text-green-600">{{ $stats['validated'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Terminés</h3>
            <p class="text-2xl font-semibold text-blue-600">{{ $stats['completed'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Montant total</h3>
            <p class="text-2xl font-semibold">{{ number_format($stats['total_amount'], 0, ',', ' ') }} FCFA</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Liste des investissements -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Numero depot</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Package</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($investissements as $investissement)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $investissement->date_initiation->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $investissement->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $investissement->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $investissement->numero_depot }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $investissement->package->nom }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ number_format($investissement->montant, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.investissements.show', $investissement) }}"
                                    class="text-indigo-600 hover:text-indigo-900">Détails</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Aucun investissement trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4">
            {{ $investissements->links() }}
        </div>
    </div>
</div>
@endsection