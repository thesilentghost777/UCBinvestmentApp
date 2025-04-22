@extends('layouts.admin')

@section('title', 'Gestion du solde')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion du solde</h1>
            <p class="text-gray-600 mt-1">Mettez à jour et suivez le solde virtuel et physique de la plateforme.</p>
        </div>
    </div>

    <!-- Current balance -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Solde actuel</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-blue-50 p-5 rounded-lg border border-blue-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-blue-700">Solde virtuel</span>
                    <i class="fas fa-database text-blue-500"></i>
                </div>
                <div class="text-3xl font-bold text-gray-900">{{ $solde ? number_format($solde->solde_virtuel, 2) : '0.00' }} XAF</div>
                <p class="text-sm text-gray-500 mt-2">Total des fonds dans le système</p>
            </div>

            <div class="bg-green-50 p-5 rounded-lg border border-green-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-green-700">Solde physique</span>
                    <i class="fas fa-wallet text-green-500"></i>
                </div>
                <div class="text-3xl font-bold text-gray-900">{{ $solde ? number_format($solde->solde_physique, 2) : '0.00' }} XAF</div>
                <p class="text-sm text-gray-500 mt-2">Fonds réels disponibles</p>
            </div>
        </div>

        <div class="mt-4 text-sm text-gray-500">
            <p>Dernière mise à jour: {{ $solde ? $solde->created_at->format('d/m/Y H:i') : 'Jamais' }}</p>
            @if($solde && $solde->notes)
                <p class="mt-1">Notes: {{ $solde->notes }}</p>
            @endif
        </div>
    </div>

    <!-- Update form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Mettre à jour le solde</h2>

        <form action="{{ route('admin.solde.update') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="solde_virtuel" class="block text-sm font-medium text-gray-700 mb-1">Solde virtuel</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">XAF</span>
                        </div>
                        <input type="number" name="solde_virtuel" id="solde_virtuel" min="0" step="0.01" class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('solde_virtuel', $solde ? $solde->solde_virtuel : 0) }}">
                    </div>
                    @error('solde_virtuel')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="solde_physique" class="block text-sm font-medium text-gray-700 mb-1">Solde physique</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">XAF</span>
                        </div>
                        <input type="number" name="solde_physique" id="solde_physique" min="0" step="0.01" class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" value="{{ old('solde_physique', $solde ? $solde->solde_physique : 0) }}">
                    </div>
                    @error('solde_physique')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (optionnel)</label>
                <textarea name="notes" id="notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" placeholder="Ajoutez des notes concernant cette mise à jour...">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>

    <!-- History -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Historique des mises à jour</h2>

        @if($history->isEmpty())
            <div class="text-center py-4 text-gray-500">
                <i class="fas fa-history text-4xl mb-2"></i>
                <p>Aucun historique disponible</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solde Virtuel</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solde Physique</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($history as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($item->solde_virtuel, 2) }} XAF</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($item->solde_physique, 2) }} XAF</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->notes ?: 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->admin->name ?? 'Système' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
