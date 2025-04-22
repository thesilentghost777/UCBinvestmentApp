<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UCBinvestment Admin - @yield('title', 'Administration')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 font-sans min-h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-blue-900 text-white w-64 min-h-screen fixed left-0 top-0 z-20 shadow-lg transform transition-transform duration-300 ease-in-out md:translate-x-0 -translate-x-full" id="sidebar">
        <div class="flex flex-col h-full">
            <!-- Logo -->
            <div class="p-4 border-b border-blue-800 flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                    <span class="font-bold text-xl tracking-tight">UCB<span class="text-yellow-400">investment</span></span>
                </a>
                <button id="mobile-close" class="md:hidden text-white focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Menu -->
            <nav class="flex-grow overflow-y-auto py-4 sidebar-scroll">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800' : 'hover:bg-blue-800' }} transition-colors">
                            <i class="fas fa-tachometer-alt w-6"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>

                    <li class="border-t border-blue-800 my-2 pt-2">
                        <span class="px-4 py-2 text-xs uppercase font-semibold text-blue-300 block">Gestion des packages</span>
                        <a href="{{ route('admin.packages.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.packages.*') ? 'bg-blue-800' : 'hover:bg-blue-800' }} transition-colors">
                            <i class="fas fa-cubes w-6"></i>
                            <span>Packages</span>
                        </a>
                    </li>

                    <li class="border-t border-blue-800 my-2 pt-2">
                        <span class="px-4 py-2 text-xs uppercase font-semibold text-blue-300 block">Gestion des tâches</span>
                        <a href="{{ route('admin.taches.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.taches.index') || request()->routeIs('admin.taches.create') || request()->routeIs('admin.taches.edit') || request()->routeIs('admin.taches.show') ? 'bg-blue-800' : 'hover:bg-blue-800' }} transition-colors">
                            <i class="fas fa-tasks w-6"></i>
                            <span>Tâches</span>
                        </a>
                        <a href="{{ route('admin.taches.statistics') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.taches.statistics') ? 'bg-blue-800' : 'hover:bg-blue-800' }} transition-colors">
                            <i class="fas fa-chart-bar w-6"></i>
                            <span>Statistiques</span>
                        </a>
                    </li>

                    <li class="border-t border-blue-800 my-2 pt-2">
                        <span class="px-4 py-2 text-xs uppercase font-semibold text-blue-300 block">Gestion des investissements</span>
                        <a href="{{ route('admin.investissements.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.investissements.index') || request()->routeIs('admin.investissements.show') ? 'bg-blue-800' : 'hover:bg-blue-800' }} transition-colors">
                            <i class="fas fa-money-bill-trend-up w-6"></i>
                            <span>Investissements</span>
                        </a>
                        <a href="{{ route('admin.investissements.pending') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.investissements.pending') ? 'bg-blue-800' : 'hover:bg-blue-800' }} transition-colors">
                            <i class="fas fa-clock w-6"></i>
                            <span>En attente</span>
                        </a>
                        <a href="{{ route('admin.investissements.statistics') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.investissements.statistics') ? 'bg-blue-800' : 'hover:bg-blue-800' }} transition-colors">
                            <i class="fas fa-chart-line w-6"></i>
                            <span>Statistiques</span>
                        </a>
                    </li>

                    <li class="border-t border-blue-800 my-2 pt-2">
                        <span class="px-4 py-2 text-xs uppercase font-semibold text-blue-300 block">Gestion des retraits</span>
                        <a href="{{ route('admin.retraits.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.retraits.index') || request()->routeIs('admin.retraits.show') ? 'bg-blue-800' : 'hover:bg-blue-800' }} transition-colors">
                            <i class="fas fa-money-bill-transfer w-6"></i>
                            <span>Retraits</span>
                        </a>
                        <a href="{{ route('admin.retraits.pending') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.retraits.pending') ? 'bg-blue-800' : 'hover:bg-blue-800' }} transition-colors">
                            <i class="fas fa-clock w-6"></i>
                            <span>En attente</span>
                        </a>
                        <a href="{{ route('admin.retraits.statistics') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.retraits.statistics') ? 'bg-blue-800' : 'hover:bg-blue-800' }} transition-colors">
                            <i class="fas fa-chart-pie w-6"></i>
                            <span>Statistiques</span>
                        </a>
                    </li>

                    <li class="border-t border-blue-800 my-2 pt-2">
                        <span class="px-4 py-2 text-xs uppercase font-semibold text-blue-300 block">Gestion des utilisateurs</span>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.users.*') ? 'bg-blue-800' : 'hover:bg-blue-800' }} transition-colors">
                            <i class="fas fa-users w-6"></i>
                            <span>Utilisateurs</span>
                        </a>

                    </li>

                    <li class="border-t border-blue-800 my-2 pt-2">
                        <span class="px-4 py-2 text-xs uppercase font-semibold text-blue-300 block">Finances</span>
                        <a href="{{ route('admin.solde') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.solde') ? 'bg-blue-800' : 'hover:bg-blue-800' }} transition-colors">
                            <i class="fas fa-wallet w-6"></i>
                            <span>Solde</span>
                        </a>

                    </li>

                    <!-- Nouvelle section pour les configurations -->
                    <li class="border-t border-blue-800 my-2 pt-2">
                        <span class="px-4 py-2 text-xs uppercase font-semibold text-blue-300 block">Configurations</span>
                        <a href="{{ route('admin.config-depots.edit') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('admin.config-depots.edit') ? 'bg-blue-800' : 'hover:bg-blue-800' }} transition-colors">
                            <i class="fas fa-cog w-6"></i>
                            <span>Configuration sup</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Footer -->
            <div class="border-t border-blue-800 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-blue-300">Administrateur</p>
                    </div>
                    <div>
                        <a href="{{ route('dashboard') }}" class="text-blue-300 hover:text-white transition-colors" title="Aller au site principal">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline-block ml-2">
                            @csrf
                            <button type="submit" class="text-blue-300 hover:text-white transition-colors" title="Déconnexion">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Overlay pour mobile -->
    <div id="sidebar-overlay" class="md:hidden fixed inset-0 bg-black bg-opacity-50 z-10 hidden" style="transition: opacity 0.3s ease-in-out;"></div>

    <div class="flex-1 md:ml-64 overflow-hidden">
        <!-- Top navbar -->
        <header class="bg-white shadow-md">
            <div class="flex items-center justify-between px-4 py-3">
                <button id="mobile-menu-button" class="md:hidden text-gray-600">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="flex items-center space-x-4">
                    <div class="relative" id="notif-dropdown">
                        <button class="text-gray-600 hover:text-gray-900 focus:outline-none">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main content -->
        <main class="p-5 overflow-y-auto" style="height: calc(100vh - 56px);">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.remove('hidden');
        });

        document.getElementById('mobile-close').addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('sidebar-overlay').classList.add('hidden');
        });

        document.getElementById('sidebar-overlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            this.classList.add('hidden');
        });

        // Notifications dropdown toggle
        document.getElementById('notif-dropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.querySelector('.dropdown-menu');
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        });

        document.addEventListener('click', function() {
            const dropdown = document.querySelector('#notif-dropdown .dropdown-menu');
            if (dropdown && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });

        // Ajuster la hauteur de la barre latérale pour le défilement
        function adjustSidebarHeight() {
            const sidebar = document.querySelector('.sidebar-scroll');
            const headerHeight = document.querySelector('#sidebar > div > div:first-child').offsetHeight;
            const footerHeight = document.querySelector('#sidebar > div > div:last-child').offsetHeight;
            const windowHeight = window.innerHeight;

            sidebar.style.height = `calc(${windowHeight}px - ${headerHeight}px - ${footerHeight}px)`;
        }

        // Exécuter au chargement et au redimensionnement
        window.addEventListener('load', adjustSidebarHeight);
        window.addEventListener('resize', adjustSidebarHeight);
    </script>
    @yield('scripts')
</body>
</html>