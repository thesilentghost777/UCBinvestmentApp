
@extends('layouts.app')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg max-w-3xl mx-auto">
    <div class="px-4 py-5 sm:px-6 bg-primary-600 text-white">
        <h3 class="text-lg leading-6 font-medium">Détails de la transaction</h3>
        <p class="mt-1 max-w-2xl text-sm">Informations complètes sur la transaction</p>
    </div>

    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Type de transaction</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    @if($transaction->type == 'deposit')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            Dépôt
                        </span>
                    @elseif($transaction->type == 'withdrawal')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            Retrait
                        </span>
                    @else
                        @if($transaction->sender_id == Auth::id())
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Transfert envoyé
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Transfert reçu
                            </span>
                        @endif
                    @endif
                </dd>
            </div>

            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Montant</dt>
                <dd class="mt-1 text-sm font-bold text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ number_format($transaction->amount, 1) }} FCFA
                </dd>
            </div>

            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Statut</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->status == 'completed' ? 'bg-green-100 text-green-800' : ($transaction->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </dd>
            </div>

            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Date et heure</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $transaction->created_at->format('d/m/Y H:i:s') }}
                </dd>
            </div>

            @if($transaction->type == 'transfer')
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Expéditeur</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $transaction->sender->full_name }} ({{ $transaction->sender->phone_number }})
                    </dd>
                </div>

                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Destinataire</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $transaction->receiver->full_name }} ({{ $transaction->receiver->phone_number }})
                    </dd>
                </div>
            @endif

            @if($transaction->description)
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $transaction->description }}
                    </dd>
                </div>
            @endif

            @if($transaction->transaction_hash)
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Hash de transaction</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 break-all">
                        {{ $transaction->transaction_hash }}
                    </dd>
                </div>
            @endif
        </dl>
    </div>

    <div class="px-4 py-4 sm:px-6 bg-gray-50 border-t border-gray-200">
        <a href="{{ route('transactions.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500">
            &larr; Retour à la liste des transactions
        </a>
    </div>
</div>
@endsection
