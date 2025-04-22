@extends('layouts.app')

@section('title', 'Mes retraits')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mes retraits</h1>
        <a href="{{ route('retraits.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-1"></i> Nouveau retrait
        </a>
    </div>

    <!-- Vue d'ensemble -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Solde disponible</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format(auth()->user()->solde_actuel, 0, ',', ' ') }} XAF</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Total retiré</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($totalRetire, 0, ',', ' ') }} XAF</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Retraits en attente</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $retraitsEnAttente }} ({{ number_format($montantEnAttente, 0, ',', ' ') }} XAF)</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des retraits -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold">Historique des retraits</h2>
        </div>

        @if($retraits->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de demande</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de validation</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($retraits as $retrait)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">
                                    #{{ $retrait->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ number_format($retrait->montant, 0, ',', ' ') }} XAF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $retrait->date_demande->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($retrait->statut == 'en_attente')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            En attente
                                        </span>
                                    @elseif($retrait->statut == 'valide')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Validé
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Refusé
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $retrait->date_validation ? $retrait->date_validation->format('d/m/Y H:i') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t">
                {{ $retraits->links() }}
            </div>
        @else
            <div class="p-6 text-center">
                <div class="h-16 w-16 rounded-full bg-blue-100 mx-auto flex items-center justify-center text-blue-600 mb-4">
                    <i class="fas fa-money-check-alt text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-1">Aucun retrait</h3>
                <p class="text-gray-600 mb-4">Vous n'avez pas encore effectué de retrait.</p>
                <a href="{{ route('retraits.create') }}" class="inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors">
                    Effectuer un retrait
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
