
@extends('layouts.app')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-lg max-w-lg mx-auto">
    <div class="px-4 py-5 sm:px-6 bg-primary-600 text-white">
        <h3 class="text-lg leading-6 font-medium">Rechercher des amis</h3>
        <p class="mt-1 max-w-2xl text-sm">Trouvez des utilisateurs en utilisant leur numéro de téléphone</p>
    </div>

    <div class="border-t border-gray-200">
        <form method="POST" action="{{ route('friends.search') }}" class="px-4 py-5 sm:p-6">
            @csrf

            <div class="mb-6">
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Numéro de téléphone</label>
                <div class="mt-1">
                    <input type="text" name="phone_number" id="phone_number" required class="focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Ex: 685001155" value="{{ old('phone_number') }}">
                </div>
                <p class="mt-2 text-sm text-gray-500">Entrez tout ou partie du numéro de téléphone pour rechercher</p>
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('friends.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Annuler
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Rechercher
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
