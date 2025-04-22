@extends('layouts.app')
@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center">
    <div class="bg-white shadow rounded-lg p-8 flex flex-col items-center">
        <svg class="h-12 w-12 text-red-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <h2 class="text-xl font-bold mb-2 text-red-700">Échec du paiement</h2>
        <div class="text-gray-700 text-center mb-4">
            Votre paiement n'a pas été validé. Veuillez réessayer ou contacter l'administration.
        </div>
        <a href="{{ route('investissements.index') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded transition">
            Retour aux investissements
        </a>
    </div>
</div>
@endsection