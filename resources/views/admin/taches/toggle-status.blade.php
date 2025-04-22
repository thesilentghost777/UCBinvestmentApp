@extends('layouts.app')

@section('title', 'Activer/Désactiver des tâches')

@section('content')
<style>
    .beer-bg {
        background: url('{{ asset('assets/img/biere.jpg') }}') center center/cover no-repeat;
        min-height: 100vh;
        position: relative;
    }
    .beer-mask {
        background: rgba(254, 198, 161, 0.88); /* Amber mask */
        position: absolute;
        inset: 0;
        z-index: 1;
    }
    .beer-content {
        position: relative;
        z-index: 2;
    }
    .amber-card {
        background: #fff;
        box-shadow: 0 5px 24px 0 #fdba7485;
    }
    .amber-badge {
        background: #FEC6A1;
        color: #000000e6;
    }
    .logo-in-page {
        height: 50px;
        width: auto;
    }
</style>

<div class="beer-bg">
    <div class="beer-mask"></div>
    <div class="beer-content container mx-auto px-3 py-10">
        <div class="mb-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <img src="{{ asset('assets/img/logo.png') }}" class="logo-in-page" alt="Logo">
                <h1 class="text-3xl md:text-4xl font-bold text-[#8E9196] drop-shadow title-font">
                    Gestion des tâches
                </h1>
            </div>
            <a href="{{ route('admin.taches.create') }}"
               class="px-5 py-2 rounded-lg shadow font-bold bg-amber-400 hover:bg-amber-500 transition-colors text-white">
                Nouvelle tâche
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded relative mb-6 font-semibold shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-xl shadow-xl amber-card">
            <table class="min-w-full divide-y divide-[#F1F0FB] text-[15px]">
                <thead class="bg-[#FEC6A1]/60">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-[#8E9196] uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-[#8E9196] uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-[#8E9196] uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-[#8E9196] uppercase tracking-wider">Complétions</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-[#8E9196] uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F1F0FB] bg-white/95">
                    @forelse($taches as $tache)
                        <tr>
                            <td class="px-6 py-3 font-semibold">
                                <span class="px-3 py-1 text-sm rounded-full
                                    @switch($tache->type)
                                        @case('youtube')
                                            bg-red-200 text-red-800
                                            @break
                                        @case('tiktok')
                                            bg-pink-200 text-pink-800
                                            @break
                                        @case('facebook')
                                            bg-blue-200 text-blue-800
                                            @break
                                        @case('instagram')
                                            bg-purple-200 text-purple-800
                                            @break
                                        @default
                                            amber-badge
                                    @endswitch
                                ">
                                    {{ ucfirst($tache->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 max-w-xs truncate text-[#000000e6]">
                                {{ $tache->description }}
                            </td>
                            <td class="px-6 py-3">
                                <form action="{{ route('admin.taches.toggle-status', $tache) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-4 py-1 rounded-full font-bold shadow text-sm
                                        {{ $tache->statut ? 'bg-green-400 hover:bg-green-500 text-white' : 'bg-amber-300 hover:bg-amber-400 text-[#8E9196]' }} transition-colors">
                                        {{ $tache->statut ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-3 font-medium text-[#8E9196]">
                                {{ $tache->completed_count ?? 0 }} / {{ $tache->taches_journalieres_count ?? 0 }}
                            </td>
                            <td class="px-6 py-3 space-x-2">
                                <a href="{{ route('admin.taches.show', $tache) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-indigo-100 hover:bg-indigo-200 text-indigo-800 font-semibold transition">
                                    <svg width="16" height="16" class="inline" fill="none" stroke="currentColor" stroke-width="2"><use xlink:href="#icon-arrow-right" /></svg>
                                    Détails
                                </a>
                                <a href="{{ route('admin.taches.edit', $tache) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-amber-50 hover:bg-amber-200 text-amber-800 font-semibold transition">
                                    <svg width="16" height="16" class="inline" fill="none" stroke="currentColor" stroke-width="2"><use xlink:href="#icon-edit" /></svg>
                                    Modifier
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-6 py-8 text-[#8E9196]">Aucune tâche trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SVG ICONS --}}
<svg style="display: none;">
    <symbol id="icon-arrow-right" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></symbol>
    <symbol id="icon-edit" viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></symbol>
</svg>
@endsection
