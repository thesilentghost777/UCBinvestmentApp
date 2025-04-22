@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Filleuls de {{ $user->name }}</h1>
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">{{ session('error') }}</div>
    @endif
    <div class="mb-6 bg-white shadow rounded-lg p-4">
        <h3 class="font-semibold mb-2">Statistiques</h3>
        <ul>
            <li>Total filleuls&nbsp;: <strong>{{ $stats['total_referrals'] }}</strong></li>
            <li>Filleuls actifs&nbsp;: <strong>{{ $stats['active_referrals'] }}</strong></li>
            <li>Bonus total versé&nbsp;: <strong>{{ $stats['total_bonus'] }} FCFA</strong></li>
        </ul>
    </div>
    <div class="bg-white shadow rounded-lg">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Nom</th>
                    <th class="py-2 px-4 border-b">Email</th>
                    <th class="py-2 px-4 border-b">Numéro</th>
                    <th class="py-2 px-4 border-b">Statut</th>
                    <th class="py-2 px-4 border-b">Bonus obtenu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($referrals as $parrainage)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $parrainage->filleul ? $parrainage->filleul->name : '-' }}</td>
                    <td class="py-2 px-4 border-b">{{ $parrainage->filleul ? $parrainage->filleul->email : '-' }}</td>
                    <td class="py-2 px-4 border-b">{{ $parrainage->filleul ? $parrainage->filleul->numero_telephone : '-' }}</td>
                    <td class="py-2 px-4 border-b">
                      @if ($parrainage->statut_filleul)
                        <span class="px-2 py-1 rounded bg-green-100 text-green-700">Actif</span>
                      @else
                        <span class="px-2 py-1 rounded bg-gray-200 text-gray-600">Non actif</span>
                      @endif
                    </td>
                    <td class="py-2 px-4 border-b">
                        {{ $parrainage->bonus_obtenu ?? 0 }} FCFA
                        @if ($parrainage->bonus_verse)
                        <span class="ml-2 text-xs text-green-600">(versé)</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $referrals->links() }}
        </div>
    </div>
</div>
@endsection