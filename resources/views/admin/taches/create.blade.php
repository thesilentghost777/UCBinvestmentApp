@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.taches.index') }}" class="mr-4 text-blue-600 hover:text-blue-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
        </a>
        <h1 class="text-2xl font-bold">Créer une nouvelle tâche</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.taches.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    <option value="">Sélectionnez un type</option>
                    <option value="youtube" {{ old('type') == 'youtube' ? 'selected' : '' }}>YouTube</option>
                    <option value="tiktok" {{ old('type') == 'tiktok' ? 'selected' : '' }}>TikTok</option>
                    <option value="facebook" {{ old('type') == 'facebook' ? 'selected' : '' }}>Facebook</option>
                    <option value="instagram" {{ old('type') == 'instagram' ? 'selected' : '' }}>Instagram</option>
                    <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="lien" class="block text-sm font-medium text-gray-700">Lien</label>
                <input type="url" name="lien" id="lien" value="{{ old('lien') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
                @error('lien')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Créer la tâche
                </button>
            </div>
        </form>
    </div>
</div>
@endsection