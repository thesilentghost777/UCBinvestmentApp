@extends('layouts.app')
@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center">
    <div class="bg-white shadow rounded-lg p-8 flex flex-col items-center">
        <h2 class="text-xl font-semibold mb-1">État du paiement</h2>
        <div class="text-gray-700 text-center mb-3">
            Statut de votre dépôt :
            <span class="font-bold">{{ $investissement->statut }}</span>
        </div>
        <a href="{{ url()->previous() }}"
           class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 transition">Retour</a>
    </div>
</div>
@endsection