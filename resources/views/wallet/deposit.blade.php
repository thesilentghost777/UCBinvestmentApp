
@extends('layouts.app')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg max-w-lg mx-auto">
    <div class="px-4 py-5 sm:px-6 bg-primary-600 text-white">
        <h3 class="text-lg leading-6 font-medium">Déposer des fonds</h3>
        <p class="mt-1 max-w-2xl text-sm">Ajoutez des FCFA à votre portefeuille</p>
    </div>

    <div class="border-t border-gray-200">
        <form method="POST" action="{{ route('wallet.deposit') }}" class="px-4 py-5 sm:p-6">            @csrf

            <div class="mb-6">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <!-- Hero icon placeholder -->
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Dans une application réelle, cette étape vous redirigerait vers une passerelle de paiement sécurisée. Pour cette démonstration, les dépôts sont simulés.
                            </p>
                        </div>
                    </div>
                </div>

                <label for="amount" class="block text-sm font-medium text-gray-700">Montant (FCFA)</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="number" name="amount" id="amount" step="0.00000001" min="0.00000001" required class="focus:ring-primary-500 focus:border-primary-500 block w-full pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="25000" value="{{ old('amount') }}">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">
                            FCFA
                        </span>
                    </div>
                </div>
                @error('amount')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('wallet.show') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Annuler
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Déposer
                </button>
            </div>
        </form>
    </div>
</div>
<br><br><br><br><br><br><br><br><br><br>
@endsection
