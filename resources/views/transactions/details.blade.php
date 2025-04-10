@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('transactions.index') }}" class="mr-2 text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Détails de la transaction</h1>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full {{ $transaction->getTypeColorClass() }}">
                        {{ ucfirst($transaction->type) }}
                    </span>
                    <span class="text-sm text-gray-500">
                        {{ $transaction->created_at->format('d/m/Y H:i:s') }}
                    </span>
                </div>
            </div>

            <!-- Transaction Details -->
            <div class="px-6 py-4">
                <div class="text-center mb-6">
                    <div class="text-2xl font-semibold {{ $transaction->type === 'deposit' || $transaction->type === 'transfer_in' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $transaction->type === 'deposit' ? '+' : ($transaction->type === 'withdrawal' ? '-' : '') }}
                        {{ number_format($transaction->amount, 2) }} XAF
                    </div>
                    @if($transaction->blockchainTransaction && $transaction->blockchainTransaction->network_fee > 0)
                        <div class="text-gray-500">Frais: {{ number_format($transaction->blockchainTransaction->network_fee, 2) }} XAF</div>
                    @endif
                </div>

                <div class="space-y-3 text-sm">
                    <!-- Transaction ID -->
                    <div class="flex justify-between">
                        <span class="text-gray-500">ID Transaction:</span>
                        <span class="font-medium">{{ $transaction->id }}</span>
                    </div>

                    <!-- Status -->
                    <div class="flex justify-between">
                        <span class="text-gray-500">Statut:</span>
                        <span class="font-medium">
                            @if($transaction->status === 'completed')
                                <span class="text-green-600">Complété</span>
                            @elseif($transaction->status === 'pending')
                                <span class="text-yellow-600">En attente</span>
                            @else
                                <span class="text-red-600">Échoué</span>
                            @endif
                        </span>
                    </div>

                    <!-- Blockchain Transaction Hash -->
                    <div class="flex justify-between">
                        <span class="text-gray-500">Hash blockchain:</span>
                        <span class="font-mono break-all">{{ $transaction->transaction_hash ?? 'N/A' }}</span>
                    </div>

                    <!-- Transfer details if applicable -->
                    @if($transaction->type === 'transfer')
                        <div class="flex justify-between">
                            <span class="text-gray-500">Expéditeur:</span>
                            <span class="font-medium">{{ $transaction->sender->username ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Destinataire:</span>
                            <span class="font-medium">{{ $transaction->receiver->username ?? 'N/A' }}</span>
                        </div>
                    @endif

                    <!-- Description if available -->
                    @if($transaction->description)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Description:</span>
                            <span class="font-medium">{{ $transaction->description }}</span>
                        </div>
                    @endif

                    <!-- Additional blockchain information if available -->
                    @if($transaction->blockchainTransaction)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <h3 class="font-semibold mb-3">Détails de la blockchain</h3>

                            @if($transaction->blockchainTransaction->block_number)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Numéro du bloc:</span>
                                    <span class="font-medium">{{ $transaction->blockchainTransaction->block_number }}</span>
                                </div>
                            @endif

                            @if($transaction->blockchainTransaction->block_hash)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Hash du bloc:</span>
                                    <span class="font-mono text-xs break-all">{{ $transaction->blockchainTransaction->block_hash }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between">
                                <span class="text-gray-500">Adresse d'origine:</span>
                                <span class="font-mono text-xs break-all">{{ $transaction->blockchainTransaction->from_address }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Adresse de destination:</span>
                                <span class="font-mono text-xs break-all">{{ $transaction->blockchainTransaction->to_address }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Réseau:</span>
                                <span class="font-medium">{{ $transaction->blockchainTransaction->network_name }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Confirmations:</span>
                                <span class="font-medium">{{ $transaction->blockchainTransaction->confirmations }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Frais réseau:</span>
                                <span class="font-medium">{{ number_format($transaction->blockchainTransaction->network_fee, 2) }} XAF</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Nonce:</span>
                                <span class="font-medium">{{ $transaction->blockchainTransaction->nonce }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Initiée le:</span>
                                <span class="font-medium">{{ $transaction->blockchainTransaction->initiated_at->format('d/m/Y H:i:s') }}</span>
                            </div>

                            @if($transaction->blockchainTransaction->processed_at)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Traitée le:</span>
                                    <span class="font-medium">{{ $transaction->blockchainTransaction->processed_at->format('d/m/Y H:i:s') }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between">
                                <span class="text-gray-500">Statut blockchain:</span>
                                <span class="font-medium">
                                    @if($transaction->blockchainTransaction->status === 'confirmed')
                                        <span class="text-green-600">Confirmée</span>
                                    @elseif($transaction->blockchainTransaction->status === 'pending' || $transaction->blockchainTransaction->status === 'processing')
                                        <span class="text-yellow-600">{{ $transaction->blockchainTransaction->status === 'pending' ? 'En attente' : 'En cours' }}</span>
                                    @else
                                        <span class="text-red-600">{{ $transaction->blockchainTransaction->status === 'failed' ? 'Échouée' : 'Abandonnée' }}</span>
                                    @endif
                                </span>
                            </div>

                            @if($transaction->blockchainTransaction->failure_reason && in_array($transaction->blockchainTransaction->status, ['failed', 'dropped']))
                                <div class="mt-4 p-3 bg-red-50 text-red-700 rounded-md">
                                    <span class="font-medium">Raison de l'échec:</span>
                                    <span class="block mt-1">{{ $transaction->blockchainTransaction->failure_reason }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Blockchain Verification -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <h3 class="text-lg font-semibold mb-2">Vérification sur la blockchain</h3>
                <p class="text-gray-600 text-sm mb-4">
                    Cette transaction est enregistrée de manière permanente sur la blockchain, assurant sa transparence et son immuabilité.
                    @if($transaction->blockchainTransaction && $transaction->blockchainTransaction->network_name)
                        <span class="block mt-1 font-medium">
                            Réseau: {{ $transaction->blockchainTransaction->network_name }}
                        </span>
                    @else
                        <span class="block mt-1 font-medium">
                            (Simulation MVP: Dans une version réelle, un lien vers un explorateur de blockchain serait fourni)
                        </span>
                    @endif
                </p>

            </div>
        </div>
    </div>
</div>
@endsection