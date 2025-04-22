@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Investissements en attente</h1>
        <a href="{{ route('admin.investissements.index') }}" class="text-blue-600 hover:text-blue-800">
            Retour à la liste
        </a>
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

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Numero de depot</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Package</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                            <form action="{{ route('admin.investissements.validate', $investissement) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Valider</button>
                            </form>
                            <form action="{{ route('admin.investissements.reject', $investissement) }}" method="POST" class="inline"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir rejeter cet investissement ?');">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-900">Rejeter</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Aucun investissement en attente
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-4">
            {{ $investissements->links() }}
        </div>
    </div>
</div>
@endsection
