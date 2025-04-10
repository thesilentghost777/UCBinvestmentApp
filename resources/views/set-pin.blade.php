@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="max-w-md mx-auto">
        <div class="flex items-center mb-6">
            <a href="#" class="mr-2 text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Définir le code PIN</h1>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-6 p-4 bg-blue-50 rounded-md text-blue-800 text-sm">
                <p><strong>Important:</strong> Votre code PIN sera utilisé pour valider vos transactions.
                Ne le partagez avec personne et choisissez un code que vous pouvez facilement mémoriser.</p>
            </div>

            <form method="POST" action="{{ route('transactions.set-pin') }}">
                @csrf

                <div class="mb-4">
                    <label for="pin" class="block text-sm font-medium text-gray-700 mb-1">Nouveau code PIN (4 chiffres)</label>
                    <input type="password" name="pin" id="pin" required maxlength="4"
                           pattern="[0-9]{4}" inputmode="numeric"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-xs text-gray-500">Le code PIN doit contenir exactement 4 chiffres</p>
                    @error('pin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="pin_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le code PIN</label>
                    <input type="password" name="pin_confirmation" id="pin_confirmation" required maxlength="4"
                           pattern="[0-9]{4}" inputmode="numeric"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('pin_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Enregistrer le code PIN
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
