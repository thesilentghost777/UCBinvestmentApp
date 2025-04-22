@extends('layouts.app')

@section('title', 'Confirmation de retrait')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-green-600 p-6 text-white text-center">
            <i class="fas fa-check-circle text-5xl mb-4"></i>
            <h1 class="text-2xl font-bold">Demande de retrait envoyée</h1>
        </div>

        <div class="p-6">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">Votre demande a été enregistrée avec succès</h2>
                <p class="mb-2">Votre demande de retrait d'un montant de <strong>{{ number_format($retrait->montant, 0, ',', ' ') }} XAF</strong> a été envoyée et sera traitée dans les meilleurs délais.</p>
                <p class="text-sm text-gray-600">Référence: #{{ $retrait->id }}</p>
            </div>

            <div class="mb-6">
                <h3 class="font-medium mb-2">Récapitulatif :</h3>
                <ul class="space-y-2">
                    <li class="flex justify-between">
                        <span class="text-gray-600">Montant :</span>
                        <span class="font-medium">{{ number_format($retrait->montant, 0, ',', ' ') }} XAF</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Numéro de réception :</span>
                        <span class="font-medium">{{ $retrait->numero_reception }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Date de demande :</span>
                        <span class="font-medium">{{ $retrait->date_demande->format('d/m/Y H:i') }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600">Statut :</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            En attente
                        </span>
                    </li>
                </ul>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-blue-800 mb-1">Que se passe-t-il maintenant ?</h4>
                        <p class="text-blue-700 text-sm">Un administrateur va traiter votre demande dans un délai de 24 à 48 heures ouvrables. Une fois validée, le montant sera envoyé sur le numéro que vous avez indiqué.</p>
                    </div>
                </div>
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('retraits.index') }}" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded text-center hover:bg-blue-700 transition-colors">
                    Mes retraits
                </a>
                <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded text-center hover:bg-gray-300 transition-colors">
                    Tableau de bord
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
