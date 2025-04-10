@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4">
    @if(session('success'))
        <div class="mb-6 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg shadow-sm transition-all duration-300 ease-in-out">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="px-4 py-5 sm:p-6">
        <!-- Welcome section -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Bonjour, {{ $user->first_name }}</h1>
            <p class="text-gray-600">Bienvenue sur votre tableau de bord</p>
        </div>

        <!-- Cards section -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Solde du portefeuille -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 overflow-hidden shadow-lg rounded-xl transition-all duration-300 hover:shadow-xl">
                <div class="px-5 py-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg p-3">
                            <svg class="h-7 w-7 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Solde disponible
                                </dt>
                                <dd>
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ number_format($wallet->balance, 2) }} FCFA
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-white bg-opacity-50 px-5 py-4">
                    <div class="text-sm">
                        <a href="{{ route('wallet.show') }}" class="font-medium text-blue-600 hover:text-blue-500 flex items-center">
                            Voir le portefeuille
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl transition-all duration-300 hover:shadow-xl">
                <div class="px-5 py-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Actions rapides</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('wallet.deposit.form') }}" class="flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Déposer
                        </a>
                        <a href="{{ route('wallet.withdraw.form') }}" class="flex items-center justify-center px-4 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                            Retirer
                        </a>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('transactions.transfer.form') }}" class="w-full flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            Transférer des fonds
                        </a>
                    </div>
                </div>
            </div>

            <!-- Trouver des amis -->
            <div class="bg-white overflow-hidden shadow-lg rounded-xl transition-all duration-300 hover:shadow-xl">
                <div class="px-5 py-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Trouver des amis</h3>
                    <div class="max-w-xl text-sm text-gray-500">
                        <p>Recherchez des amis par numéro de téléphone pour des transferts faciles.</p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('friends.search.form') }}" class="inline-flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Rechercher des amis
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick links -->
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('friends.index') }}" class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center">
                <div class="rounded-full bg-blue-100 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">Mes amis</h3>
                    <p class="text-sm text-gray-500">Gérer vos contacts</p>
                </div>
            </a>

            <a href="{{ route('transactions.index') }}" class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center">
                <div class="rounded-full bg-emerald-100 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">Historique</h3>
                    <p class="text-sm text-gray-500">Vos transactions</p>
                </div>
            </a>

            <a href="{{ route('set.pin') }}" class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center">
                <div class="rounded-full bg-amber-100 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">Code PIN</h3>
                    <p class="text-sm text-gray-500">Configurer votre sécurité</p>
                </div>
            </a>

            <a href="{{ route('profile.edit') }}" class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex items-center">
                <div class="rounded-full bg-purple-100 p-3 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900">Profil</h3>
                    <p class="text-sm text-gray-500">Gérer vos informations</p>
                </div>
            </a>
        </div>

        <!-- Transactions récentes -->
        <div class="mt-10">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-xl font-semibold text-gray-800">Transactions récentes</h3>
                <a href="{{ route('transactions.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 flex items-center">
                    Voir tout
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            @if(count($recentTransactions) > 0)
                <div class="bg-white shadow-md rounded-xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Montant
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Voir</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($recentTransactions as $transaction)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($transaction->type == 'deposit')
                                                    <div class="flex-shrink-0 rounded-full bg-blue-100 p-2 mr-3">
                                                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="text-sm text-gray-900">Dépôt</div>
                                                @elseif($transaction->type == 'withdrawal')
                                                    <div class="flex-shrink-0 rounded-full bg-amber-100 p-2 mr-3">
                                                        <svg class="h-4 w-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="text-sm text-gray-900">Retrait</div>
                                                @else
                                                    @if($transaction->sender_id == $user->id)
                                                        <div class="flex-shrink-0 rounded-full bg-indigo-100 p-2 mr-3">
                                                            <svg class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="text-sm text-gray-900">Transfert à {{ $transaction->receiver->full_name }}</div>
                                                    @else
                                                        <div class="flex-shrink-0 rounded-full bg-emerald-100 p-2 mr-3">
                                                            <svg class="h-4 w-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="text-sm text-gray-900">Reçu de {{ $transaction->sender->full_name }}</div>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium {{ $transaction->sender_id == $user->id && $transaction->type == 'transfer' ? 'text-red-500' : 'text-emerald-500' }}">
                                                {{ $transaction->sender_id == $user->id && $transaction->type == 'transfer' ? '-' : '+' }}{{ number_format($transaction->amount, 2) }} FCFA
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->status == 'completed' ? 'bg-emerald-100 text-emerald-800' : ($transaction->status == 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $transaction->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('transactions.show', $transaction) }}" class="text-blue-600 hover:text-blue-800 transition-colors duration-200">Détails</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white p-6 rounded-xl shadow-md text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p class="mt-4 text-gray-600">Aucune transaction récente.</p>
                    <a href="{{ route('transactions.transfer.form') }}" class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                        Effectuer votre première transaction
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection