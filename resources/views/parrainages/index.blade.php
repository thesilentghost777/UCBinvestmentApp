@extends('layouts.app')

@section('title', 'Mon réseau de parrainage')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mon réseau de parrainage</h1>
        <p class="text-gray-600">Parrainez vos amis et gagnez 10% de leurs investissements.</p>
    </div>

    <!-- Vue d'ensemble -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Total de filleuls</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ auth()->user()->filleuls()->count() }}</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Filleuls actifs</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $filleulsActifs }}</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Commissions gagnées</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($commissionsGagnees, 0, ',', ' ') }} XAF</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Lien de parrainage -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4">Mon lien de parrainage</h2>
        <p class="text-gray-600 mb-4">Partagez ce lien avec vos amis et gagnez 10% de leurs investissements.</p>

        <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-4">
            <div class="flex-grow">
                <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg border">
                    <input type="text" id="referral_link" value="{{ url('register?code=' . auth()->user()->code_parrainage) }}" readonly class="bg-transparent border-none w-full focus:outline-none text-gray-800">
                    <button onclick="copyToClipboard('referral_link')" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition-colors">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <div class="flex-shrink-0">
                <div class="flex space-x-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('register?code=' . auth()->user()->code_parrainage)) }}" target="_blank" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode('Rejoignez UCBinvestment et gagnez de l\'argent en complétant des tâches simples. Utilisez mon code de parrainage pour vous inscrire : ' . url('register?code=' . auth()->user()->code_parrainage)) }}" target="_blank" class="bg-green-600 text-white p-2 rounded hover:bg-green-700 transition-colors">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode('Rejoignez UCBinvestment et gagnez de l\'argent en complétant des tâches simples. Utilisez mon code de parrainage pour vous inscrire :') }}&url={{ urlencode(url('register?code=' . auth()->user()->code_parrainage)) }}" target="_blank" class="bg-blue-400 text-white p-2 rounded hover:bg-blue-500 transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="mailto:?subject={{ urlencode('Rejoignez UCBinvestment avec mon code de parrainage') }}&body={{ urlencode('Bonjour,\n\nJe vous invite à rejoindre UCBinvestment, une plateforme qui vous permet de gagner de l\'argent en complétant des tâches simples.\n\nUtilisez mon code de parrainage pour vous inscrire : ' . url('register?code=' . auth()->user()->code_parrainage) . '\n\nCordialement,') }}" class="bg-red-600 text-white p-2 rounded hover:bg-red-700 transition-colors">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <p class="text-gray-600">Mon code de parrainage: <span class="font-semibold">{{ auth()->user()->code_parrainage }}</span></p>
        </div>
    </div>

    <!-- Mes filleuls -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold">Mes filleuls</h2>
        </div>

        @php
            $filleuls = auth()->user()->filleuls()->paginate(10);
        @endphp

        @if($filleuls->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'inscription</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commissions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($filleuls as $filleul)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $filleul->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $filleul->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $filleul->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($filleul->investissements()->where('statut', 'validé')->count() > 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Actif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Inactif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @php
                                        $commission = auth()->user()->parrainagesEnTantQueParrain()
                                            ->where('filleul_id', $filleul->id)
                                            ->sum('bonus_obtenu');
                                    @endphp
                                    {{ number_format($commission, 0, ',', ' ') }} XAF
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t">
                {{ $filleuls->links() }}
            </div>
        @else
            <div class="p-6 text-center">
                <div class="h-16 w-16 rounded-full bg-yellow-100 mx-auto flex items-center justify-center text-yellow-600 mb-4">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-1">Aucun filleul</h3>
                <p class="text-gray-600 mb-4">Vous n'avez pas encore de filleuls. Partagez votre lien de parrainage pour commencer à gagner des commissions.</p>
            </div>
        @endif
    </div>

    <!-- Comment ça marche -->
    <div class="mt-8 bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold">Comment fonctionne le parrainage ?</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mb-4">
                        <span class="text-lg font-bold">1</span>
                    </div>
                    <h3 class="font-medium mb-2">Partagez votre lien</h3>
                    <p class="text-gray-600">Partagez votre lien de parrainage ou votre code avec vos amis, votre famille et sur les réseaux sociaux.</p>
                </div>

                <div>
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mb-4">
                        <span class="text-lg font-bold">2</span>
                    </div>
                    <h3 class="font-medium mb-2">Ils s'inscrivent et investissent</h3>
                    <p class="text-gray-600">Vos filleuls s'inscrivent avec votre code et investissent dans un package de leur choix.</p>
                </div>

                <div>
                    <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mb-4">
                        <span class="text-lg font-bold">3</span>
                    </div>
                    <h3 class="font-medium mb-2">Vous gagnez 10% de commission</h3>
                    <p class="text-gray-600">Vous recevez automatiquement une commission de 10% sur le montant investi par chacun de vos filleuls.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyToClipboard(elementId) {
        const element = document.getElementById(elementId);
        element.select();
        document.execCommand('copy');

        // Afficher une notification
        alert('Lien de parrainage copié !');
    }
</script>
@endpush
@endsection