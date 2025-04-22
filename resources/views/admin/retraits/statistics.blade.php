@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex items-center">
        <h1 class="text-2xl font-bold">Statistiques sur les retraits</h1>
        <a href="{{ route('admin.retraits.index') }}" class="ml-auto px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition">Retour à la liste</a>
    </div>
    <div class="mb-6 grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="p-4 bg-white shadow rounded-lg">
            <p class="text-gray-500 text-xs uppercase">Montant total validé</p>
            <p class="text-xl font-bold">{{ number_format($stats['total_amount'], 0, ',', ' ') }} FCFA</p>
        </div>
        <div class="p-4 bg-white shadow rounded-lg">
            <p class="text-gray-500 text-xs uppercase">Nombre total</p>
            <p class="text-xl font-bold">{{ $stats['total_count'] }}</p>
        </div>
        <div class="p-4 bg-white shadow rounded-lg">
            <p class="text-gray-500 text-xs uppercase">Montant moyen</p>
            <p class="text-xl font-bold">{{ number_format($stats['avg_amount'], 0, ',', ' ') }} FCFA</p>
        </div>
        <div class="p-4 bg-white shadow rounded-lg">
            <p class="text-gray-500 text-xs uppercase">Retraits aujourd'hui</p>
            <p class="text-xl font-bold">{{ $stats['today_count'] }}</p>
        </div>
        <div class="p-4 bg-white shadow rounded-lg">
            <p class="text-gray-500 text-xs uppercase">Montant ajd</p>
            <p class="text-xl font-bold">{{ number_format($stats['today_amount'], 0, ',', ' ') }} FCFA</p>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Évolution des retraits sur 30 jours</h2>
        <canvas id="withdrawalsChart" style="height: 280px;"></canvas>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('withdrawalsChart').getContext('2d');
            const withdrawalsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($dailyLabels) !!},
                    datasets: [{
                        label: 'Montant validé (FCFA)',
                        data: {!! json_encode($dailyData) !!},
                        borderColor: '#4F46E5',
                        backgroundColor: 'rgba(79,70,229,0.18)',
                        fill: true,
                        tension: 0.2,
                        pointRadius: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString() + ' FCFA';
                                }
                            }
                        }
                    },
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        </script>
    </div>
</div>
@endsection