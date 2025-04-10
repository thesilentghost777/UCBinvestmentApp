
@extends('layouts.app')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg max-w-lg mx-auto">
    <div class="px-4 py-5 sm:px-6 bg-primary-600 text-white">
        <h3 class="text-lg leading-6 font-medium">Résultats de recherche</h3>
        <p class="mt-1 max-w-2xl text-sm">Utilisateurs trouvés pour "{{ request('phone_number') }}"</p>
    </div>

    <div class="border-t border-gray-200">
        @if(count($users) > 0)
            <div class="overflow-hidden">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($users as $user)
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
                                                {{ $user->full_name }}
                                            </p>
                                            <p class="mt-1 text-sm text-gray-500 truncate">
                                                {{ $user->phone_number }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    @if($user->friendship_status === 'accepted')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Déjà ami
                                        </span>
                                    @elseif($user->friendship_status === 'pending')
                                        @if($user->is_sender)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Demande envoyée
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Demande reçue
                                            </span>
                                        @endif
                                    @elseif($user->friendship_status === 'declined')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Demande refusée
                                        </span>
                                    @else
                                        <form method="POST" action="{{ route('friends.send-request') }}">
                                            @csrf
                                            <input type="hidden" name="friend_id" value="{{ $user->id }}">
                                            <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                Ajouter
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="px-4 py-5 sm:p-6 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun utilisateur trouvé</h3>
                <p class="mt-1 text-sm text-gray-500">Essayez avec un autre numéro de téléphone.</p>
            </div>
        @endif
    </div>

    <div class="px-4 py-4 sm:px-6 bg-gray-50 border-t border-gray-200">
        <div class="flex justify-between">
            <a href="{{ route('friends.search.form') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500">
                &larr; Nouvelle recherche
            </a>
            <a href="{{ route('friends.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-500">
                Retour à mes amis &rarr;
            </a>
        </div>
    </div>
</div>
@endsection
