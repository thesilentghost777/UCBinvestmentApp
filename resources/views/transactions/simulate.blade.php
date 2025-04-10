@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="max-w-4xl mx-auto">

        <!-- Transaction Card -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <div class="bg-blue-600 px-6 py-4 text-white">
                <h2 class="text-xl font-semibold">Détails de la Transaction</h2>
                <p class="text-sm opacity-80">Examen des données de transaction sur la blockchain {{ $blockchainTransaction->network_name }}</p>
            </div>

            <div class="p-6">
                <!-- Transaction Hash -->
                <div class="mb-6">
                    <h3 class="text-gray-500 text-sm mb-1">Hash de Transaction</h3>
                    <div class="flex items-center space-x-2">
                        <p class="font-mono text-sm break-all bg-gray-50 p-2 rounded border border-gray-200 flex-grow">
                            {{ $blockchainTransaction->transaction_hash }}
                        </p>
                        <button class="text-blue-500 hover:text-blue-700" title="Copier le hash">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Status & Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-gray-500 text-sm mb-1">Statut</h3>
                        <div class="flex items-center">
                            @if($blockchainTransaction->status === 'confirmed')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Confirmée ({{ $blockchainTransaction->confirmations }} confirmations)
                                </span>
                            @elseif($blockchainTransaction->status === 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="animate-spin w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    En attente
                                </span>
                            @elseif($blockchainTransaction->status === 'processing')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <svg class="animate-spin w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    En cours de traitement
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $blockchainTransaction->status === 'failed' ? 'Échouée' : 'Abandonnée' }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h3 class="text-gray-500 text-sm mb-1">Horodatage</h3>
                        <p class="font-medium">
                            {{ $blockchainTransaction->initiated_at->format('d/m/Y H:i:s') }}
                            <span class="text-sm text-gray-500">({{ $blockchainTransaction->initiated_at->diffForHumans() }})</span>
                        </p>
                    </div>
                </div>

                <!-- Transaction Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-gray-500 text-sm mb-1">Montant</h3>
                        <p class="font-medium text-lg">{{ number_format($blockchainTransaction->amount, 2) }} XAF</p>
                    </div>

                    <div>
                        <h3 class="text-gray-500 text-sm mb-1">Frais de réseau</h3>
                        <p class="font-medium">{{ number_format($blockchainTransaction->network_fee, 2) }} XAF</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Block Information -->
                    <div>
                        <h3 class="text-gray-500 text-sm mb-1">Bloc</h3>
                        @if($blockchainTransaction->block_number)
                            <p class="font-medium">
                                <a href="#" class="text-blue-600 hover:underline">{{ $blockchainTransaction->block_number }}</a>
                            </p>
                        @else
                            <p class="text-yellow-600">En attente d'inclusion dans un bloc</p>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-gray-500 text-sm mb-1">Nonce</h3>
                        <p class="font-medium">{{ $blockchainTransaction->nonce }}</p>
                    </div>
                </div>

                <!-- From / To Addresses -->
                <div class="mb-6">
                    <h3 class="text-gray-500 text-sm mb-1">De</h3>
                    <div class="flex items-center space-x-2">
                        <p class="font-mono text-sm break-all bg-gray-50 p-2 rounded border border-gray-200 flex-grow">
                            {{ $blockchainTransaction->from_address }}
                        </p>
                        <button class="text-blue-500 hover:text-blue-700" title="Copier l'adresse">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-gray-500 text-sm mb-1">Vers</h3>
                    <div class="flex items-center space-x-2">
                        <p class="font-mono text-sm break-all bg-gray-50 p-2 rounded border border-gray-200 flex-grow">
                            {{ $blockchainTransaction->to_address }}
                        </p>
                        <button class="text-blue-500 hover:text-blue-700" title="Copier l'adresse">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Block Hash if available -->
                @if($blockchainTransaction->block_hash)
                <div class="mb-6">
                    <h3 class="text-gray-500 text-sm mb-1">Hash du bloc</h3>
                    <div class="flex items-center space-x-2">
                        <p class="font-mono text-sm break-all bg-gray-50 p-2 rounded border border-gray-200 flex-grow">
                            {{ $blockchainTransaction->block_hash }}
                        </p>
                        <button class="text-blue-500 hover:text-blue-700" title="Copier le hash">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                    </div>
                </div>
                @endif

                <!-- Failure reason if applicable -->
                @if($blockchainTransaction->failure_reason && in_array($blockchainTransaction->status, ['failed', 'dropped']))
                <div class="mb-6">
                    <h3 class="text-gray-500 text-sm mb-1">Raison de l'échec</h3>
                    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-md">
                        {{ $blockchainTransaction->failure_reason }}
                    </div>
                </div>
                @endif

                <!-- Gas Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($blockchainTransaction->gas_price)
                    <div>
                        <h3 class="text-gray-500 text-sm mb-1">Prix du gaz</h3>
                        <p class="font-medium">{{ number_format($blockchainTransaction->gas_price, 8) }} ETH</p>
                    </div>
                    @endif

                    @if($blockchainTransaction->gas_used)
                    <div>
                        <h3 class="text-gray-500 text-sm mb-1">Gaz utilisé</h3>
                        <p class="font-medium">{{ number_format($blockchainTransaction->gas_used) }} unités</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Transaction Timeline -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Chronologie de la transaction</h2>
            </div>

            <div class="p-6">
                <div class="relative">
                    <div class="absolute left-4 top-0 h-full w-0.5 bg-gray-200"></div>

                    <!-- Timeline items -->
                    <div class="mb-8 ml-8 relative">
                        <div class="absolute -left-10 mt-1.5 rounded-full border-4 border-white bg-blue-500 h-6 w-6 flex items-center justify-center">
                            <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                            <h3 class="font-semibold text-gray-800">Transaction initiée</h3>
                            <time class="block mb-2 text-sm text-gray-500">{{ $blockchainTransaction->initiated_at->format('d/m/Y H:i:s') }}</time>
                            <p class="text-gray-600">Transaction créée et soumise au réseau {{ $blockchainTransaction->network_name }}.</p>
                        </div>
                    </div>

                    @if($blockchainTransaction->status === 'pending' || $blockchainTransaction->status === 'processing' || $blockchainTransaction->status === 'confirmed')
                    <div class="mb-8 ml-8 relative">
                        <div class="absolute -left-10 mt-1.5 rounded-full border-4 border-white {{ $blockchainTransaction->status === 'pending' ? 'bg-yellow-500' : 'bg-blue-500' }} h-6 w-6 flex items-center justify-center">
                            <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                            <h3 class="font-semibold text-gray-800">Transaction incluse dans le pool</h3>
                            <time class="block mb-2 text-sm text-gray-500">{{ $blockchainTransaction->initiated_at->addMinutes(1)->format('d/m/Y H:i:s') }}</time>
                            <p class="text-gray-600">La transaction a été acceptée dans le pool de transactions en attente.</p>
                        </div>
                    </div>
                    @endif

                    @if($blockchainTransaction->status === 'processing' || $blockchainTransaction->status === 'confirmed')
                    <div class="mb-8 ml-8 relative">
                        <div class="absolute -left-10 mt-1.5 rounded-full border-4 border-white bg-blue-500 h-6 w-6 flex items-center justify-center">
                            <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                            <h3 class="font-semibold text-gray-800">Transaction en cours de traitement</h3>
                            <time class="block mb-2 text-sm text-gray-500">{{ $blockchainTransaction->initiated_at->addMinutes(2)->format('d/m/Y H:i:s') }}</time>
                            <p class="text-gray-600">Un mineur est en train de traiter la transaction.</p>
                        </div>
                    </div>
                    @endif

                    @if($blockchainTransaction->status === 'confirmed')
                    <div class="mb-8 ml-8 relative">
                        <div class="absolute -left-10 mt-1.5 rounded-full border-4 border-white bg-green-500 h-6 w-6 flex items-center justify-center">
                            <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                            <h3 class="font-semibold text-gray-800">Transaction confirmée</h3>
                            <time class="block mb-2 text-sm text-gray-500">{{ $blockchainTransaction->processed_at ? $blockchainTransaction->processed_at->format('d/m/Y H:i:s') : $blockchainTransaction->initiated_at->addMinutes(5)->format('d/m/Y H:i:s') }}</time>
                            <p class="text-gray-600">
                                La transaction a été confirmée et incluse dans le bloc #{{ $blockchainTransaction->block_number }}.
                                Elle a désormais {{ $blockchainTransaction->confirmations }} confirmation(s).
                            </p>
                        </div>
                    </div>
                    @endif

                    @if($blockchainTransaction->status === 'failed' || $blockchainTransaction->status === 'dropped')
                    <div class="ml-8 relative">
                        <div class="absolute -left-10 mt-1.5 rounded-full border-4 border-white bg-red-500 h-6 w-6 flex items-center justify-center">
                            <svg class="h-3 w-3 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="bg-white rounded-lg border border-red-200 p-4 shadow-sm">
                            <h3 class="font-semibold text-red-800">Transaction {{ $blockchainTransaction->status === 'failed' ? 'échouée' : 'abandonnée' }}</h3>
                            <time class="block mb-2 text-sm text-gray-500">{{ $blockchainTransaction->processed_at ? $blockchainTransaction->processed_at->format('d/m/Y H:i:s') : $blockchainTransaction->initiated_at->addMinutes(5)->format('d/m/Y H:i:s') }}</time>
                            <p class="text-gray-600">
                                La transaction n'a pas pu être traitée.
                                @if($blockchainTransaction->failure_reason)
                                <span class="block mt-2 text-red-600">Raison: {{ $blockchainTransaction->failure_reason }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Technical Information -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Informations techniques</h2>
            </div>

            <div class="p-6">
                <div class="bg-gray-50 font-mono text-sm p-4 rounded-lg overflow-x-auto">
                    <pre>{
    "blockHash": "{{ $blockchainTransaction->block_hash ?? 'null' }}",
    "blockNumber": {{ $blockchainTransaction->block_number ?? 'null' }},
    "from": "{{ $blockchainTransaction->from_address }}",
    "to": "{{ $blockchainTransaction->to_address }}",
    "gas": {{ $blockchainTransaction->gas_used ?? 21000 }},
    "gasPrice": "{{ $blockchainTransaction->gas_price ?? '0.000000005' }}",
    "hash": "{{ $blockchainTransaction->transaction_hash }}",
    "input": "0x",
    "nonce": {{ $blockchainTransaction->nonce }},
    "value": "{{ $blockchainTransaction->amount }}",
    "networkName": "{{ $blockchainTransaction->network_name }}",
    "timestamp": "{{ $blockchainTransaction->initiated_at->timestamp }}",
    "status": "{{ $blockchainTransaction->status }}",
    "confirmations": {{ $blockchainTransaction->confirmations }}
}</pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection