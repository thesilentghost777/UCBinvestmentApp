@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-2xl">
    <div class="flex items-center mb-6">
        <a href="{{ url()->previous() }}" class="mr-4 text-blue-600 hover:text-blue-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Retour
        </a>
        <h1 class="text-2xl font-bold ml-2">Détail du retrait #{{ $retrait->id }}</h1>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <dl>
            <div class="mb-4">
                <dt class="text-xs text-gray-500">Utilisateur</dt>
                <dd class="font-semibold">{{ $retrait->user->name ?? '-' }} ({{ $retrait->user->email ?? '' }})</dd>
            </div>
            <div class="mb-4">
                <dt class="text-xs text-gray-500">Montant</dt>
                <dd class="font-bold text-lg">{{ number_format($retrait->montant, 0, ',', ' ') }} FCFA</dd>
            </div>
            <div class="mb-4">
                <dt class="text-xs text-gray-500">Statut</dt>
                <dd>
                    @if($retrait->statut === 'validé')
                        <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs font-medium">Validé</span>
                    @elseif($retrait->statut === 'en_attente')
                        <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800 text-xs font-medium">En attente</span>
                    @else
                        <span class="px-2 py-1 rounded bg-gray-200 text-gray-700 text-xs font-medium">{{ ucfirst($retrait->statut) }}</span>
                    @endif
                </dd>
            </div>
            <div class="mb-4">
                <dt class="text-xs text-gray-500">Date de la demande</dt>
                <dd>{{ \Carbon\Carbon::parse($retrait->date_demande)->format('d/m/Y H:i') }}</dd>
            </div>
            <div class="mb-4">
                <dt class="text-xs text-gray-500">Date de validation</dt>
                <dd>
                    @if($retrait->date_validation)
                        {{ \Carbon\Carbon::parse($retrait->date_validation)->format('d/m/Y H:i') }}
                    @else
                        -
                    @endif
                </dd>
            </div>
            <div class="mb-4">
                <dt class="text-xs text-gray-500">N° réception</dt>
                <dd>{{ $retrait->numero_reception ?? '-' }}</dd>
            </div>
            <div class="mb-4">
                <dt class="text-xs text-gray-500">UID utilisateur</dt>
                <dd>{{ $retrait->user_id }}</dd>
            </div>
        </dl>
    </div>
    <a href="{{ route('admin.retraits.index') }}" class="inline-block px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition">Retour à la liste</a>
</div>
@endsection