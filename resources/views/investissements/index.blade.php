@extends('layouts.app')

@section('title', 'Mes investissements')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mes investissements</h1>
        <a href="{{ route('investissements.create') }}" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-1"></i> Nouvel investissement
        </a>
    </div>

    <!-- Vue d'ensemble -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Investissements actifs</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ auth()->user()->investissements()->where('statut', 'validé')->count() }}</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <i class="fas fa-check"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">En attente de validation</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ auth()->user()->investissements()->where('statut', 'en_attente')->count() }}</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Total investi</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format(auth()->user()->investissements()->sum('montant'), 0, ',', ' ') }} XAF</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des investissements -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold">Historique des investissements</h2>
        </div>

        @php
            $investissements = auth()->user()->investissements()->with('package')->latest('created_at')->paginate(10);
        @endphp

        @if($investissements->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($investissements as $investissement)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $investissement->package->nom }}</div>
                                    <div class="text-sm text-gray-500">Gain journalier: {{ number_format($investissement->package->gain_journalier, 0, ',', ' ') }} XAF</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ number_format($investissement->montant, 0, ',', ' ') }} XAF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $investissement->date_initiation->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('investissements.show', $investissement) }}" class="text-blue-600 hover:text-blue-900">Détails</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t">
                {{ $investissements->links() }}
            </div>
        @else
            <div class="p-6 text-center">
                <div class="h-16 w-16 rounded-full bg-blue-100 mx-auto flex items-center justify-center text-blue-600 mb-4">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-1">Aucun investissement</h3>
                <p class="text-gray-600 mb-4">Vous n'avez pas encore investi dans un package.</p>
                <a href="{{ route('investissements.create') }}" class="inline-block bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors">
                    Investir maintenant
                </a>
            </div>
        @endif
    </div>
</div>
@endsection