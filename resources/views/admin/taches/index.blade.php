@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestion des tâches</h1>
        <a href="{{ route('admin.taches.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Nouvelle tâche
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Complétions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($taches as $tache)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full
                                @switch($tache->type)
                                    @case('youtube')
                                        bg-red-100 text-red-800
                                        @break
                                    @case('tiktok')
                                        bg-pink-100 text-pink-800
                                        @break
                                    @case('facebook')
                                        bg-blue-100 text-blue-800
                                        @break
                                    @case('instagram')
                                        bg-purple-100 text-purple-800
                                        @break
                                    @default
                                        bg-gray-100 text-gray-800
                                @endswitch
                            ">
                                {{ ucfirst($tache->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 truncate max-w-md">{{ $tache->description }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.taches.toggle-status', $tache) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1 text-xs rounded-full
                                    {{ $tache->statut ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $tache->statut ? 'true' : 'false' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $tache->completed_count }} / {{ $tache->taches_journalieres_count }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                            <a href="{{ route('admin.taches.show', $tache) }}" class="text-indigo-600 hover:text-indigo-900">
                                Détails
                            </a>
                            <a href="{{ route('admin.taches.edit', $tache) }}" class="text-yellow-600 hover:text-yellow-900">
                                Modifier
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Aucune tâche trouvée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection