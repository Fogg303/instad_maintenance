<!DOCTYPE html>
<html lang="fr" x-data="{ isMenuOpen: false }">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Dashboard for INSTAD Maintenance Platform" />
    <meta name="author" content="INSTAD Team" />
    <title>Admin Dashboard - INSTAD</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        instadBlue: '#1E3A8A',
                        instadDark: '#1E293B',
                        instadSecondary: '#3B82F6'
                    }
                }
            }
        };
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .user-menu {
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">

    <!-- Top Navigation -->
    <nav class="bg-instadBlue text-white shadow-lg fixed w-full z-50">
        <div class="mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <button id="sidebarToggle" class="lg:hidden">
                    <i class="bi bi-list text-2xl"></i>
                </button>
                <a href="#" class="flex items-center">
                    <img src="{{ asset('assets/img/instad-logo.jpg') }}" alt="INSTAD Logo" class="h-10">
                </a>
            </div>
            
            <div class="flex items-center space-x-6">
                <div class="relative group">
                    <button class="flex items-center space-x-2 focus:outline-none">
                        <i class="bi bi-bell text-xl"></i>
                        <span class="bg-red-500 text-xs px-2 py-1 rounded-full">3</span>
                    </button>
                </div>
                
                <!-- Menu Utilisateur -->
                <div class="relative" x-data="{ open: false }">
                    <button 
                        @click="open = !open"
                        class="flex items-center space-x-2 focus:outline-none"
                    >
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" 
                             class="h-8 w-8 rounded-full border-2 border-white">
                        <span class="font-medium">{{ Auth::user()->name }}</span>
                        <i class="bi bi-chevron-down text-sm"></i>
                    </button>
                    
                    <div 
                        class="user-menu absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-lg py-1 z-50"
                        x-show="open"
                        @click.away="open = false"
                        x-cloak
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                    >
                        <a 
                            href="{{ route('profile.edit') }}" 
                            class="flex items-center px-4 py-3 hover:bg-gray-100 space-x-3"
                        >
                            <i class="bi bi-person"></i>
                            <span>Mon Profil</span>
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button 
                                type="submit"
                                class="w-full text-left flex items-center px-4 py-3 hover:bg-gray-100 space-x-3"
                            >
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-instadDark text-white fixed h-screen shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-40">
        <div class="p-6 text-xl font-bold border-b border-blue-500">Menu Admin</div>
        <nav class="mt-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 hover:bg-blue-600 space-x-3">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
            
            <!-- Gestion des Types -->
            <a href="{{ route('admin.equipment-types.index') }}" 
            class="flex items-center px-4 py-3 hover:bg-blue-600 space-x-3 
                    {{ request()->routeIs('admin.equipment-types.*') ? 'bg-blue-700' : '' }}">
                <i class="bi bi-tags"></i>
                <span>Types d'Équipements</span>
            </a>

            <!-- Gestion des Caractéristiques -->
            <a href="{{ route('admin.characteristics.index') }}" 
            class="flex items-center px-4 py-3 hover:bg-blue-600 space-x-3 
                    {{ request()->routeIs('admin.characteristics.*') ? 'bg-blue-700' : '' }}">
                <i class="bi bi-card-checklist"></i>
                <span>Caractéristiques</span>
            </a>

            <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-600 space-x-3">
                <i class="bi bi-people"></i>
                <span>Utilisateurs</span>
            </a>
            
            <a href="{{ route('admin.directions.index') }}" class="flex items-center px-4 py-3 hover:bg-blue-600 space-x-3">
                <i class="bi bi-building"></i>
                <span>Directions</span>
            </a>
            
            <!-- Équipements Utilisateurs -->
            <a href="{{ route('admin.equipments.index') }}" 
            class="flex items-center px-4 py-3 hover:bg-blue-600 space-x-3 
                    {{ request()->routeIs('admin.equipments.*') ? 'bg-blue-700' : '' }}">
                <i class="bi bi-pc-display"></i>
                <span>Équipements</span>
            </a>
            
            <a href="" class="flex items-center px-4 py-3 hover:bg-blue-600 space-x-3">
                <i class="bi bi-clipboard-check"></i>
                <span>Demandes</span>
            </a>
            
            <a href="" class="flex items-center px-4 py-3 hover:bg-blue-600 space-x-3">
                <i class="bi bi-bar-chart"></i>
                <span>Reporting</span>
            </a>
        </nav>
    </aside>
    <!-- Main Content -->
    <main class="lg:ml-64 pt-20 px-4 min-h-screen">
        <div class="py-6">
            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });

        
    </script>
</body>
</html>