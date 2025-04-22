@extends('layouts.admin')

@section('title', 'Créer un nouveau package')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-800 to-blue-600 px-6 py-4 relative">
            <h2 class="text-xl font-bold text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                Créer un nouveau package
            </h2>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 via-blue-500 to-red-500"></div>
        </div>

        <!-- Form content -->
        <form action="{{ route('admin.packages.store') }}" method="POST" class="p-6">
            @csrf

            <div class="space-y-6">
                <!-- Nom du package -->
                <div>
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">
                        Nom du package <span class="text-red-500">*</span>
                    </label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <input type="text" id="nom" name="nom" value="{{ old('nom') }}"
                            class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-4 py-3 border-gray-300 rounded-lg @error('nom') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                            placeholder="Entrez le nom du package" required>
                    </div>
                    @error('nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Two columns grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Montant investissement -->
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-100 transition-all hover:shadow-md">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-blue-700 text-white p-2 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label for="montant_investissement" class="block text-sm font-medium text-gray-700">
                                    Montant d'investissement <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 relative">
                                    <input type="number" step="0.01" id="montant_investissement" name="montant_investissement"
                                        value="{{ old('montant_investissement') }}"
                                        class="block w-full pr-10 py-2 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 @error('montant_investissement') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                        required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <span class="text-gray-500">F CFA</span>
                                    </div>
                                </div>
                                @error('montant_investissement')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Valeur par tâche -->
                    <div class="bg-green-50 rounded-lg p-4 border border-green-100 transition-all hover:shadow-md">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-green-600 text-white p-2 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label for="valeur_par_tache" class="block text-sm font-medium text-gray-700">
                                    Valeur par tâche <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 relative">
                                    <input type="number" step="0.01" id="valeur_par_tache" name="valeur_par_tache"
                                        value="{{ old('valeur_par_tache') }}"
                                        class="block w-full pr-10 py-2 border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500 @error('valeur_par_tache') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                        required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <span class="text-gray-500">F CFA</span>
                                    </div>
                                </div>
                                @error('valeur_par_tache')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Gain journalier -->
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-100 transition-all hover:shadow-md">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-blue-500 text-white p-2 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label for="gain_journalier" class="block text-sm font-medium text-gray-700">
                                    Gain journalier <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 relative">
                                    <input type="number" step="0.01" id="gain_journalier" name="gain_journalier"
                                        value="{{ old('gain_journalier') }}"
                                        class="block w-full pr-10 py-2 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 @error('gain_journalier') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                        required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <span class="text-gray-500">FCFA</span>
                                    </div>
                                </div>
                                @error('gain_journalier')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>


                </div>

                <!-- Form actions -->
                <div class="flex justify-between items-center pt-5 mt-6 border-t border-gray-200">
                    <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition-all duration-200 ease-in-out transform hover:-translate-y-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-4 text-center text-xs text-gray-500">
        <p>Les champs marqués d'un <span class="text-red-500">*</span> sont obligatoires</p>
    </div>
</div>
@endsection