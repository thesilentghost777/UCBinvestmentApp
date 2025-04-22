<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCBinvestment - @yield('title', 'Investissez et gagnez')</title>
    <meta name="description" content="Plateforme d'investissement UCBinvestment - Investissez et gagnez de l'argent en complétant des tâches simples.">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-md mb-4 flex items-start gap-3">
        <svg class="w-6 h-6 text-red-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 9v2m0 4h.01M4.93 4.93l14.14 14.14M4.93 19.07L19.07 4.93"></path>
        </svg>
        <div>
            @foreach ($errors->all() as $error)
                <p class="text-sm font-medium">{{ $error }}</p>
            @endforeach
        </div>
    </div>
@endif


    <!-- Navigation principale -->
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold">UCBinvestment</a>
                </div>

                @auth
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded hover:bg-blue-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-home mr-1"></i> Accueil
                    </a>
                    <a href="{{ route('investissements.index') }}" class="px-3 py-2 rounded hover:bg-blue-700 transition-colors {{ request()->routeIs('investissements.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-dollar-sign mr-1"></i> Investissements
                    </a>
                    <a href="{{ route('taches.index') }}" class="px-3 py-2 rounded hover:bg-blue-700 transition-colors {{ request()->routeIs('taches.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-tasks mr-1"></i> Tâches
                    </a>
                    <a href="{{ route('retraits.index') }}" class="px-3 py-2 rounded hover:bg-blue-700 transition-colors {{ request()->routeIs('retraits.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-wallet mr-1"></i> Retraits
                    </a>
                    <a href="{{ route('parrainages.index') }}" class="px-3 py-2 rounded hover:bg-blue-700 transition-colors {{ request()->routeIs('parrainages.*') ? 'bg-blue-700' : '' }}">
                        <i class="fas fa-users mr-1"></i> Parrainage
                    </a>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="hidden md:flex items-center px-3 py-2 bg-green-600 rounded">
                        <i class="fas fa-coins mr-1"></i>
                        <span>{{ number_format(auth()->user()->solde_actuel, 0, ',', ' ') }} XAF</span>
                    </div>

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center focus:outline-none">
                            <span class="hidden md:block mr-1">{{ auth()->user()->name }}</span>
                            <i class="fas fa-user-circle text-xl"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                <i class="fas fa-user mr-2"></i> Profil
                            </a>
                            @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-blue-100">
                                <i class="fas fa-cogs mr-2"></i> Admin
                            </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Menu mobile -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
                @else
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="px-3 py-2 bg-white text-blue-600 rounded hover:bg-blue-50 transition-colors">Connexion</a>
                    <a href="{{ route('register') }}" class="px-3 py-2 bg-blue-700 rounded hover:bg-blue-800 transition-colors">Inscription</a>
                </div>
                @endauth
            </div>

            <!-- Mobile menu -->
            @auth
            <div id="mobile-menu" class="md:hidden hidden pt-4 pb-2">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-blue-700 mb-1 {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-home mr-1"></i> Accueil
                </a>
                <a href="{{ route('investissements.index') }}" class="block px-3 py-2 rounded hover:bg-blue-700 mb-1 {{ request()->routeIs('investissements.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-dollar-sign mr-1"></i> Investissements
                </a>
                <a href="{{ route('taches.index') }}" class="block px-3 py-2 rounded hover:bg-blue-700 mb-1 {{ request()->routeIs('taches.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-tasks mr-1"></i> Tâches
                </a>
                <a href="{{ route('retraits.index') }}" class="block px-3 py-2 rounded hover:bg-blue-700 mb-1 {{ request()->routeIs('retraits.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-wallet mr-1"></i> Retraits
                </a>
                <a href="{{ route('parrainages.index') }}" class="block px-3 py-2 rounded hover:bg-blue-700 mb-1 {{ request()->routeIs('parrainages.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-users mr-1"></i> Parrainage
                </a>
                <div class="flex items-center px-3 py-2 bg-green-600 rounded mt-2 mb-1">
                    <i class="fas fa-coins mr-1"></i>
                    <span>{{ number_format(auth()->user()->solde_actuel, 0, ',', ' ') }} XAF</span>
                </div>
            </div>
            @endauth
        </div>
    </nav>

    <!-- Messages d'alerte -->
    <div class="container mx-auto px-4 py-2">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('warning') }}</span>
            </div>
        @endif

        @if (session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('info') }}</span>
            </div>
        @endif
    </div>

    <!-- Contenu principal -->
    <main class="flex-grow container mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- Pied de page -->
    <!-- Pied de page -->
<footer class="bg-blue-800 text-white py-6">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <h2 class="text-lg font-bold">UCBinvestment</h2>
                <p class="text-sm opacity-75">Investissez et gagnez facilement</p>
            </div>
            <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-6">
                <a href="/apropos" class="hover:text-blue-300 transition-colors text-sm">À propos</a>
                <a href="https://wa.me/237678367592" class="hover:text-blue-300 transition-colors text-sm">Service client</a>

                <div class="flex space-x-4">
                    <a href="https://facebook.com" target="_blank" class="hover:text-blue-300 transition-colors"><i class="fab fa-facebook"></i></a>
                    <a href="https://twitter.com" target="_blank" class="hover:text-blue-300 transition-colors"><i class="fab fa-twitter"></i></a>
                    <a href="https://instagram.com" target="_blank" class="hover:text-blue-300 transition-colors"><i class="fab fa-instagram"></i></a>
                    <a href="https://youtube.com" target="_blank" class="hover:text-blue-300 transition-colors"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <div class="mt-6 pt-6 border-t border-blue-700 text-center text-sm opacity-75">
            <p>&copy; {{ date('Y') }} UCBinvestment. Tous droits réservés.</p>
        </div>
    </div>
</footer>

    @stack('scripts')
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        });
    </script>
</body>
</html>
