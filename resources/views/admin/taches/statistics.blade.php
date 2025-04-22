@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Statistiques des tâches</h1>

    <!-- Stats générales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Total des tâches</h3>
            <p class="text-2xl font-semibold">{{ $stats['total_taches'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Tâches actives</h3>
            <p class="text-2xl font-semibold">{{ $stats['active_taches'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Total des attributions</h3>
            <p class="text-2xl font-semibold">{{ $stats['total_attributions'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500 text-sm">Total des gains</h3>
            <p class="text-2xl font-semibold">{{ number_format($stats['total_earnings'], 0, ',', ' ') }} FCFA</p>
        </div>
    </div>

    <!-- Taux de complétion par type -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-lg font-semibold mb-4">Taux de complétion par type</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total attribué</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Complétées</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Taux</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($completionRateByType as $type)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($type->type) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $type->total_assigned }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $type->total_completed }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2 max-w-[200px]">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $type->completion_rate }}%"></div>
                                    </div>
                                    <span>{{ number_format($type->completion_rate, 1) }}%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Graphique des complétions par jour -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-semibold mb-4">Complétions par jour (30 derniers jours)</h2>
        <canvas id="completionsChart" height="100"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('completionsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyLabels) !!},
            datasets: [{
                label: 'Nombre de complétions',
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
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
