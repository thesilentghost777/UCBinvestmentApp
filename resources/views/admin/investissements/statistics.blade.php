@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Statistiques des investissements</h1>

    <!-- Stats générales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Montant total</h3>
            <p class="text-2xl font-semibold">{{ number_format($stats['total_amount'], 0, ',', ' ') }} FCFA</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Nombre total</h3>
            <p class="text-2xl font-semibold">{{ $stats['total_count'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Montant moyen</h3>
            <p class="text-2xl font-semibold">{{ number_format($stats['avg_amount'], 0, ',', ' ') }} FCFA</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Aujourd'hui (nombre)</h3>
            <p class="text-2xl font-semibold">{{ $stats['today_count'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Aujourd'hui (montant)</h3>
            <p class="text-2xl font-semibold">{{ number_format($stats['today_amount'], 0, ',', ' ') }} FCFA</p>
        </div>
    </div>

    <!-- Distribution par package -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-lg font-semibold mb-4">Distribution par package</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Package</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Distribution</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($packageDistribution as $package)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $package->nom }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $package->investissements_count }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ number_format($package->investissements_sum_montant ?? 0, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2 max-w-[200px]">
                                        @php
                                            $percentage = $stats['total_count'] > 0
                                                ? ($package->investissements_count / $stats['total_count']) * 100
                                                : 0;
                                        @endphp
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span>{{ number_format($percentage, 1) }}%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Graphique des investissements par jour -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">Investissements par jour (30 derniers jours)</h2>
        <canvas id="investmentsChart" height="100"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('investmentsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyLabels) !!},
            datasets: [{
                label: 'Montant des investissements',
                data: {!! json_encode($dailyData) !!},
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('fr-FR') + ' FCFA';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
