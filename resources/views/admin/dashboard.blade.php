@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tableau de bord administrateur</h1>
            <p class="text-gray-600 mt-1">Bienvenue {{ Auth::user()->name }}. Voici une vue d'ensemble de votre plateforme.</p>
        </div>
        <div class="mt-4 md:mt-0 flex flex-col md:flex-row gap-2">
            <a href="{{ route('admin.investissements.pending') }}" class="inline-flex items-center justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-money-bill-trend-up mr-2"></i> Investissements en attente
                @if($stats['pending_investments'] > 0)
                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-white text-blue-600">{{ $stats['pending_investments'] }}</span>
                @endif
            </a>
            <a href="{{ route('admin.retraits.pending') }}" class="inline-flex items-center justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="fas fa-money-bill-transfer mr-2"></i> Retraits en attente
                @if($stats['pending_withdrawals'] > 0)
                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-white text-green-600">{{ $stats['pending_withdrawals'] }}</span>
                @endif
            </a>
        </div>
    </div>

    <!-- Stats cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-md p-5 transition-transform transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="text-gray-500">Utilisateurs</div>
                <div class="text-blue-500 bg-blue-100 p-2 rounded-full">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</span>
                <span class="text-sm text-green-500 ml-2">
                    <i class="fas fa-circle text-xs"></i> {{ number_format($stats['active_users']) }} actifs
                </span>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    Gérer les utilisateurs <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-5 transition-transform transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="text-gray-500">Investissements</div>
                <div class="text-purple-500 bg-purple-100 p-2 rounded-full">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_investments']) }}</span>
                <span class="text-sm text-yellow-500 ml-2">
                    <i class="fas fa-clock text-xs"></i> {{ number_format($stats['pending_investments']) }} en attente
                </span>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.investissements.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    Gérer les investissements <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-5 transition-transform transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="text-gray-500">Tâches complétées</div>
                <div class="text-green-500 bg-green-100 p-2 rounded-full">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-bold text-gray-900">{{ number_format($stats['completed_tasks']) }}</span>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.taches.statistics') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    Voir les statistiques <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-5 transition-transform transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="text-gray-500">Retraits effectués</div>
                <div class="text-red-500 bg-red-100 p-2 rounded-full">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_withdrawn']) }} XAF</span>
                <span class="text-sm text-yellow-500 ml-2">
                    <i class="fas fa-clock text-xs"></i> {{ number_format($stats['pending_withdrawals']) }} en attente
                </span>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.retraits.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    Gérer les retraits <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Graphs section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md p-5">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Inscriptions des 30 derniers jours</h3>
            <div class="h-80">
                <canvas id="registrationChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-5">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribution des investissements par package</h3>
            <div class="h-80">
                <canvas id="investmentsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Solde actuel -->
    <div class="bg-white rounded-lg shadow-md p-5">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Solde de la plateforme</h3>
                <p class="text-gray-600 text-sm">Dernière mise à jour: {{ $solde ? $solde->created_at->format('d/m/Y H:i') : 'Jamais' }}</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('admin.solde') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-edit mr-2"></i>
                    Mettre à jour
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-gray-500 text-sm">Solde virtuel (dans le système)</div>
                <div class="text-2xl font-bold text-gray-900">{{ $solde ? number_format($solde->solde_virtuel, 2) : 0 }} XAF</div>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-gray-500 text-sm">Solde physique (réel)</div>
                <div class="text-2xl font-bold text-gray-900">{{ $solde ? number_format($solde->solde_physique, 2) : 0 }} XAF</div>
            </div>
        </div>
    </div>

    <!-- Packages disponibles -->
    <div class="bg-white rounded-lg shadow-md p-5">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Packages disponibles</h3>
                <p class="text-gray-600 text-sm">{{ $stats['total_packages'] }} packages configurés</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('admin.packages.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter un package
                </a>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.packages.index') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                Voir tous les packages <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inscriptions Chart
        const registrationCtx = document.getElementById('registrationChart').getContext('2d');
        const registrationChart = new Chart(registrationCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($last30Days->pluck('date')) !!},
                datasets: [{
                    label: 'Nouveaux utilisateurs',
                    data: {!! json_encode($last30Days->pluck('count')) !!},
                    fill: true,
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderColor: 'rgb(59, 130, 246)',
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Investments Chart
        const investmentsCtx = document.getElementById('investmentsChart').getContext('2d');
        const investmentsChart = new Chart(investmentsCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($investmentsData->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($investmentsData->pluck('count')) !!},
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(245, 158, 11, 0.7)',
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(139, 92, 246, 0.7)',
                        'rgba(14, 165, 233, 0.7)',
                        'rgba(249, 115, 22, 0.7)',
                        'rgba(236, 72, 153, 0.7)',
                        'rgba(168, 85, 247, 0.7)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });
    });
</script>
@endsection
