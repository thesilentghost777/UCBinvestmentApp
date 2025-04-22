@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center mb-6">
        <h1 class="text-2xl font-bold">Retraits en attente</h1>
        <a href="{{ route('admin.retraits.index') }}" class="ml-auto px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition">Retour à la liste</a>
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

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date demande</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($retraits as $retrait)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $retrait->id }}</td>
                        <td class="px-4 py-2">
                            <span class="font-semibold">{{ $retrait->user->name ?? '-' }}</span>
                            <br>
                            <span class="text-xs text-gray-400">{{ $retrait->user->email ?? '' }}</span>
                        </td>
                        <td class="px-4 py-2">{{ number_format($retrait->montant, 0, ',', ' ') }} FCFA</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($retrait->date_demande)->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2 flex flex-col gap-2 min-w-[200px]">
                            <form action="{{ route('admin.retraits.validate', $retrait) }}" method="POST" class="flex flex-row gap-1">
                                @csrf
                                <input type="text" name="numero_reception" placeholder="N° réception" required class="rounded px-2 py-1 border border-gray-200 text-sm">
                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition text-sm">Valider</button>
                            </form>
                            <form action="{{ route('admin.retraits.reject', $retrait) }}" method="POST"
                                  onsubmit="return confirm('Confirmer le rejet et la restauration du solde ?')">
                                @csrf
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition text-sm mt-1">Rejeter</button>
                            </form>
                            <a href="{{ route('admin.retraits.show', $retrait) }}" class="inline-block text-blue-700 hover:underline text-xs mt-1">Voir détails</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 text-gray-500">Aucun retrait en attente.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-3">
            {{ $retraits->links() }}
        </div>
    </div>
</div>
@endsection
