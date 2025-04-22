@extends('layouts.admin')

@section('title', 'Modifier un package')

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <div class="rounded-xl shadow-lg overflow-hidden bg-white">
        <div class="bg-gradient-to-tr from-primary via-[#9b87f5] to-[#7E69AB] px-6 py-6">
            <h2 class="text-xl font-semibold text-white flex items-center gap-2">
                {{-- Icon edit --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6 3.536 3.536-6 6H9v-3.536zM4 21h16" />
                </svg>
                Modifier le package : <span class="ml-1">{{ $package->nom }}</span>
            </h2>
        </div>
        <div class="px-8 py-8 bg-[#F1F0FB]">
            <form action="{{ route('admin.packages.update', $package) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="nom" class="block font-semibold text-[#6E59A5] mb-1">Nom du package <span class="text-red-600">*</span></label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom', $package->nom) }}"
                        class="w-full border border-[#D6BCFA] rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary/60 text-gray-800 bg-white shadow-inner @error('nom') border-red-400 @enderror"
                        placeholder="Entrez le nom du package" required>
                    @error('nom')
                        <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="montant_investissement" class="block font-semibold text-[#6E59A5] mb-1">Montant investissement <span class="text-red-600">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-[#7E69AB]">
                                {{-- Icon money --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.333 0-4 .5-4 3s2.667 3 4 3 4 .5 4 3-2.667 3-4 3M12 8v2m0 4v2" />
                                </svg>
                            </span>
                            <input type="number" step="0.01" id="montant_investissement" name="montant_investissement" value="{{ old('montant_investissement', $package->montant_investissement) }}"
                                class="w-full border border-[#D6BCFA] rounded-lg px-8 py-2 focus:outline-none focus:ring-2 focus:ring-primary/60 text-gray-800 bg-white shadow-inner @error('montant_investissement') border-red-400 @enderror"
                                required>
                        </div>
                        @error('montant_investissement')
                            <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                   \
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="valeur_par_tache" class="block font-semibold text-[#6E59A5] mb-1">Valeur par tâche <span class="text-red-600">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-[#7E69AB]">
                                {{-- Icon check circle --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <input type="number" step="0.01" id="valeur_par_tache" name="valeur_par_tache" value="{{ old('valeur_par_tache', $package->valeur_par_tache) }}"
                                class="w-full border border-[#D6BCFA] rounded-lg px-8 py-2 focus:outline-none focus:ring-2 focus:ring-primary/60 text-gray-800 bg-white shadow-inner @error('valeur_par_tache') border-red-400 @enderror"
                                required>
                        </div>
                        @error('valeur_par_tache')
                            <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="gain_journalier" class="block font-semibold text-[#6E59A5] mb-1">Gain journalier <span class="text-red-600">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-[#9b87f5]">
                                {{-- Icon trending-up --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 17l6-6 4 4 8-8" />
                                </svg>
                            </span>
                            <input type="number" step="0.01" id="gain_journalier" name="gain_journalier" value="{{ old('gain_journalier', $package->gain_journalier) }}"
                                class="w-full border border-[#D6BCFA] rounded-lg px-8 py-2 focus:outline-none focus:ring-2 focus:ring-primary/60 text-gray-800 bg-white shadow-inner @error('gain_journalier') border-red-400 @enderror"
                                required>
                        </div>
                        @error('gain_journalier')
                            <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-center">

                    <div class="mt-6 md:mt-8 flex gap-3 items-center">
                        <input type="checkbox" id="actif" name="actif" value="1"
                            class="h-5 w-5 text-primary focus:ring-2 focus:ring-offset-2 border-[#D6BCFA] rounded bg-white"
                            {{ $package->actif ? 'checked' : '' }}>
                        <label for="actif" class="ml-2 font-medium text-[#6E59A5]">Package actif</label>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row justify-between gap-3 pt-6">
                    <a href="{{ route('admin.packages.index') }}"
                       class="inline-flex items-center justify-center gap-2 px-6 py-2 rounded bg-[#E5DEFF] text-[#7E69AB] font-semibold hover:bg-[#d6bcfa] hover:text-[#6E59A5] transition-colors shadow">
                        {{-- Icon left arrow --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Retour
                    </a>
                    <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-6 py-2 rounded bg-[#7E69AB] text-white font-semibold shadow hover:bg-[#6E59A5] transition-colors">
                    {{-- Icon save --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7M5 6h14v4H5z" />
                    </svg>
                    Mettre à jour
                </button>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
