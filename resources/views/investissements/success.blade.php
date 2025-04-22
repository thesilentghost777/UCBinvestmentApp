@extends('layouts.app')
@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center">
    <div class="bg-white shadow rounded-lg p-8 flex flex-col items-center">
        <svg class="h-12 w-12 text-green-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
        </svg>
        <h2 class="text-xl font-bold mb-2 text-green-700">Dépôt validé !</h2>
        <div class="text-gray-700 text-center mb-4">
            Votre paiement a été validé. Vous pouvez passer à l'étape suivante.
        </div>
        <a href="{{ route('taches.index') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded transition">
            Accéder à mes tâches
        </a>
    </div>
</div>
@endsection