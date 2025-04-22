@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Profil de {{ $user->name }}</h1>
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">{{ session('error') }}</div>
    @endif
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="font-semibold mb-2">Informations personnelles</h3>
                <ul>
                    <li><strong>Nom :</strong> {{ $user->name }}</li>
                    <li><strong>Email :</strong> {{ $user->email }}</li>
                    <li><strong>Téléphone :</strong> {{ $user->numero_telephone ?? '-' }}</li>
                    <li><strong>Statut :</strong>
                      <span class="px-2 py-1 rounded {{ $user->statut ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                      {{ $user->statut ? 'Actif' : 'Inactif' }}
                      </span>
                    </li>
                </ul>
                <div class="mt-4">
                    <a href="{{ route('admin.users.edit', $user) }}" class="mr-2 text-blue-700 hover:underline">Modifier</a>

                </div>
            </div>
            <div>
                <h3 class="font-semibold mb-2">Statistiques</h3>
                <ul>
                    <li>Total investi : <strong>{{ $stats['total_invested'] }} FCFA</strong></li>
                    <li>Tâches accomplies : <strong>{{ $stats['total_tasks_completed'] }}</strong></li>
                    <li>Gains (tâches) : <strong>{{ $stats['total_earnings'] }} FCFA</strong></li>
                    <li>Retraits validés : <strong>{{ $stats['total_withdrawals'] }} FCFA</strong></li>
                    <li>Packages actifs : <strong>{{ $stats['active_packages'] }}</strong></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-2">Parrainage</h3>
                <ul>
                    <li>Nombre filleuls : <strong>{{ $stats['referrals_count'] }}</strong></li>
                    <li>Filleuls actifs : <strong>{{ $stats['active_referrals'] }}</strong></li>
                    <li>Gains parrainage : <strong>{{ $stats['referral_earnings'] }} FCFA</strong></li>
                </ul>
                <a href="{{ route('admin.users.referrals', $user) }}" class="block mt-2 text-purple-700 hover:underline">Voir les filleuls</a>
            </div>
        </div>
        <div class="mt-6">
            <h3 class="font-semibold mb-2">Investissements</h3>
            @if($user->investissements->count())
                <ul>
                  @foreach ($user->investissements as $inv)
                    <li class="border-b py-2">
                        #{{ $inv->id }} – {{ $inv->package ? $inv->package->nom : '' }} :
                        <strong>{{ $inv->montant }} FCFA</strong> ({{ $inv->statut }})
                        <span class="text-sm text-gray-400 ml-4">{{ $inv->date_initiation }}</span>
                    </li>
                  @endforeach
                </ul>
            @else
                <div class="text-gray-500 italic">Aucun investissement trouvé.</div>
            @endif
        </div>
        <div class="mt-6">
            <h3 class="font-semibold mb-2">Retraits</h3>
            @if($user->retraits && $user->retraits->count())
                <ul>
                  @foreach ($user->retraits as $retrait)
                    <li class="border-b py-2">
                        #{{ $retrait->id }} – {{ $retrait->montant }} FCFA ({{ $retrait->statut }})
                        <span class="text-sm text-gray-400 ml-4">{{ $retrait->created_at }}</span>
                    </li>
                  @endforeach
                </ul>
            @else
                <div class="text-gray-500 italic">Aucun retrait trouvé.</div>
            @endif
        </div>
    </div>

</div>
@endsection
