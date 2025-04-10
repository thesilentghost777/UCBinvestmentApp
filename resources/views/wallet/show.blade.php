
@extends('layouts.app')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6 bg-primary-600 text-white">
        <h3 class="text-lg leading-6 font-medium">Mon portefeuille</h3>
        <p class="mt-1 max-w-2xl text-sm">Détails et actions sur votre portefeuille Ethereum</p>
    </div>
    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="bg-gray-50 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Détails du portefeuille</h3>
                    <dl class="mt-4 grid grid-cols-1 gap-5">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Adresse du portefeuille</dt>
                            <dd class="mt-1 text-sm text-gray-900 break-all">{{ $wallet->address }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Solde actuel</dt>
                            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($wallet->balance, 1) }} FCFA</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dernière mise à jour</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $wallet->updated_at->format('d/m/Y H:i:s') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Actions sur le portefeuille</h3>
                    <div class="mt-4 space-y-4">
                        <a href="{{ route('wallet.deposit.form') }}" class="block w-full bg-primary-600 text-white text-center py-2 px-4 rounded-md hover:bg-primary-700 transition duration-200">
                            Déposer des fonds
                        </a>
                        <a href="{{ route('wallet.withdraw.form') }}" class="block w-full bg-secondary-600 text-white text-center py-2 px-4 rounded-md hover:bg-secondary-700 transition duration-200">
                            Retirer des fonds
                        </a>
                        <a href="{{ route('transactions.transfer.form') }}" class="block w-full bg-gray-800 text-white text-center py-2 px-4 rounded-md hover:bg-gray-900 transition duration-200">
                            Transférer des fonds
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<br><br><br><br><br><br><br><br><br>
@endsection
