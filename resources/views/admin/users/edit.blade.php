@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Modifier l'utilisateur</h1>
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">{{ session('error') }}</div>
    @endif
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-1">Nom</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="border rounded px-3 py-2 w-full" required>
            @error('name')
                <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="border rounded px-3 py-2 w-full" required>
            @error('email')
                <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Téléphone</label>
            <input type="text" name="numero_telephone" value="{{ old('numero_telephone', $user->numero_telephone) }}" class="border rounded px-3 py-2 w-full" required>
            @error('numero_telephone')
                <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Solde actuel (FCFA)</label>
            <input type="number" name="solde_actuel" value="{{ old('solde_actuel', $user->solde_actuel) }}" step="0.01" class="border rounded px-3 py-2 w-full" required>
            @error('solde_actuel')
                <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4 flex items-center">
            <label for="statut" class="font-semibold mb-1 mr-3">Utilisateur actif </label>
            <input type="checkbox" name="statut" id="statut" {{ old('statut', $user->statut) ? 'checked' : '' }}/>
        </div>
        <button type="submit" class="bg-indigo-600 text-white rounded px-6 py-2">Enregistrer</button>
    </form>
</div>
@endsection
