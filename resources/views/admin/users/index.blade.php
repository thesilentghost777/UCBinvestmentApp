@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Liste des Utilisateurs</h1>
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">{{ session('error') }}</div>
    @endif
    <table class="min-w-full bg-white shadow rounded-lg">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Nom</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Téléphone</th>
                <th class="py-2 px-4 border-b">Statut</th>
                <th class="py-2 px-4 border-b">Investissements</th>
                <th class="py-2 px-4 border-b">Tâches complètes</th>
                <th class="py-2 px-4 border-b">Filleuls</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr>
                <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                <td class="py-2 px-4 border-b">{{ $user->numero_telephone ?? '-' }}</td>
                <td class="py-2 px-4 border-b">
                    <span class="px-2 py-1 rounded {{ $user->statut ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                        {{ $user->statut ? 'Actif' : 'Inactif' }}
                    </span>
                </td>
                <td class="py-2 px-4 border-b">{{ $user->investissements_count }}</td>
                <td class="py-2 px-4 border-b">{{ $user->taches_journalieres_count }}</td>
                <td class="py-2 px-4 border-b">{{ $user->filleuls_count }}</td>
                <td class="py-2 px-4 border-b">
                    <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-700 hover:underline mr-2">Voir</a>
                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:underline mr-2">Modifier</a>
                    <a href="{{ route('admin.users.referrals', $user) }}" class="text-purple-600 hover:underline">Filleuls</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="py-4 px-4 text-center text-gray-400">Aucun utilisateur trouvé.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection