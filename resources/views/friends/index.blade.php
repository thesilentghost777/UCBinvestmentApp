
@extends('layouts.app')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6 bg-primary-600 text-white flex justify-between items-center">
        <div>
            <h3 class="text-lg leading-6 font-medium">Mes amis</h3>
            <p class="mt-1 max-w-2xl text-sm">Gérez vos contacts pour des transferts plus faciles</p>
        </div>
        <a href="{{ route('friends.search.form') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-primary-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-primary-600 focus:ring-white">
            Rechercher des amis
        </a>
    </div>

    <!-- Demandes d'amitié en attente -->
    @if(count($pendingReceivedRequests) > 0)
        <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Demandes d'amitié reçues</h3>

            <div class="bg-yellow-50 p-4 rounded-md mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- Hero icon placeholder -->
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Vous avez {{ count($pendingReceivedRequests) }} demande(s) d'amitié en attente.
                        </p>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($pendingReceivedRequests as $request)
                        <li>
                            <div class="flex items-center px-4 py-4 sm:px-6">
                                <div class="min-w-0 flex-1 flex items-center">
                                    <div class="flex-shrink-0 bg-primary-100 rounded-full p-2">
                                        <!-- Hero icon placeholder -->
                                        <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1 px-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $request->user->full_name }}
                                            </p>
                                            <p class="mt-1 text-sm text-gray-500 truncate">
                                                {{ $request->user->phone_number }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <form method="POST" action="{{ route('friends.accept-request') }}">
                                        @csrf
                                        <input type="hidden" name="friendship_id" value="{{ $request->id }}">
                                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            Accepter
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('friends.decline-request') }}">
                                        @csrf
                                        <input type="hidden" name="friendship_id" value="{{ $request->id }}">
                                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                            Refuser
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Demandes d'amitié envoyées -->
    @if(count($pendingSentRequests) > 0)
        <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Demandes d'amitié envoyées</h3>

            <div class="overflow-hidden sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($pendingSentRequests as $request)
                        <li>
                            <div class="flex items-center px-4 py-4 sm:px-6">
                                <div class="min-w-0 flex-1 flex items-center">
                                    <div class="flex-shrink-0 bg-primary-100 rounded-full p-2">
                                        <!-- Hero icon placeholder -->
                                        <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1 px-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $request->friend->full_name }}
                                            </p>
                                            <p class="mt-1 text-sm text-gray-500 truncate">
                                                {{ $request->friend->phone_number }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        En attente
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Amis acceptés -->
    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Mes amis</h3>

        @if(count($acceptedFriends) > 0)
            <div class="overflow-hidden sm:rounded-md">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($acceptedFriends as $friendship)
                        <li>
                            <div class="flex items-center px-4 py-4 sm:px-6">
                                <div class="min-w-0 flex-1 flex items-center">
                                    <div class="flex-shrink-0 bg-primary-100 rounded-full p-2">
                                        <!-- Hero icon placeholder -->
                                        <svg class="h-6 w-6 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1 px-4">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $friendship->friend->full_name }}
                                            </p>
                                            <p class="mt-1 text-sm text-gray-500 truncate">
                                                {{ $friendship->friend->phone_number }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('transactions.transfer.form') }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                        Transférer
                                    </a>

                                    <form method="POST" action="{{ route('friends.remove') }}">
                                        @csrf
                                        <input type="hidden" name="friendship_id" value="{{ $friendship->id }}">
                                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="text-center py-10 px-4">
                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun ami</h3>
                <p class="mt-1 text-sm text-gray-500">Commencez par rechercher des amis en utilisant leur numéro de téléphone.</p>
                <div class="mt-6">
                    <a href="{{ route('friends.search.form') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Rechercher des amis
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
<br><br.<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
@endsection
