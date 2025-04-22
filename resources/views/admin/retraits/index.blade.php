@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center mb-6">
        <h1 class="text-2xl font-bold">Liste des retraits</h1>
        <a href="{{ route('admin.retraits.statistics') }}" class="ml-auto px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Statistiques</a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 border-l-4 border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-6 grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="p-4 bg-white shadow rounded-lg">
            <p class="text-gray-500 text-xs uppercase">Total retraits</p>
            <p class="text-xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="p-4 bg-white shadow rounded-lg">
            <p class="text-gray-500 text-xs uppercase">En attente</p>
            <p class="text-xl font-bold">{{ $stats['pending'] }}</p>
        </div>
        <div class="p-4 bg-white shadow rounded-lg">
            <p class="text-gray-500 text-xs uppercase">Validés</p>
            <p class="text-xl font-bold">{{ $stats['validated'] }}</p>
        </div>
        <div class="p-4 bg-white shadow rounded-lg">
            <p class="text-gray-500 text-xs uppercase">Montant validé</p>
            <p class="text-xl font-bold">{{ number_format($stats['total_amount'], 0, ',', ' ') }} FCFA</p>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Demande</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Validation</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($retraits as $retrait)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $retrait->id }}</td>
                        <td class="px-4 py-2">
                            <span class="font-semibold">{{ $retrait->user->name ?? '-' }}</span>
                            <br>
                            <span class="text-xs text-gray-400">{{ $retrait->user->email ?? '' }}</span>
                        </td>
                        <td class="px-4 py-2">{{ number_format($retrait->montant, 0, ',', ' ') }} FCFA</td>
                        <td class="px-4 py-2">
                            @if($retrait->statut === 'validé')
                                <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs font-medium">Validé</span>
                            @elseif($retrait->statut === 'en_attente')
                                <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800 text-xs font-medium">En attente</span>
                            @else
                                <span class="px-2 py-1 rounded bg-gray-200 text-gray-700 text-xs font-medium">{{ ucfirst($retrait->statut) }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($retrait->date_demande)->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">
                            @if($retrait->date_validation)
                                {{ \Carbon\Carbon::parse($retrait->date_validation)->format('d/m/Y H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.retraits.show', $retrait) }}" class="text-blue-700 hover:underline text-sm">Détails</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-3">
            {{ $retraits->links() }}
        </div>
    </div>
</div>
@endsection
