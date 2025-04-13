<!DOCTYPE html>
<html lang="fr" x-data="{ isMenuOpen: false }">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title') - INSTAD</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        userPrimary: '#4F46E5',
                        userSecondary: '#6366F1',
                        userDark: '#312E81',
                        userLight: '#EEF2FF'
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
        .badge-new {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">

    <!-- Top Navigation -->
    <nav class="bg-userPrimary text-white shadow-lg fixed w-full z-50">
        <div class="mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <button @click="isMenuOpen = !isMenuOpen" class="lg:hidden">
                    <i class="bi bi-list text-2xl"></i>
                </button>
                <a href="#" class="flex items-center">
                    <img src="{{ asset('assets/img/instad-logo.jpg') }}" alt="INSTAD Logo" class="h-10">
                </a>
            </div>
            
            <div class="flex items-center space-x-6">
                <!-- Notifications -->
                <div class="relative group" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <i class="bi bi-bell text-xl"></i>
                        <span class="badge-new absolute -top-1 -right-1 bg-red-500 text-xs px-2 py-1 rounded-full">3</span>
                    </button>
                    
                    <div class="user-menu absolute right-0 mt-2 w-72 bg-white text-gray-800 rounded-lg py-1 z-50"
                        x-show="open"
                        @click.away="open = false"
                        x-cloak
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95">
                        
                        <div class="px-4 py-3 border-b">
                            <h3 class="font-medium">Notifications</h3>
                        </div>
                        
                       
                    </div>
                </div>
                
                <!-- User Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" 
                             class="h-8 w-8 rounded-full border-2 border-white">
                        <span class="font-medium">{{ Auth::user()->name }}</span>
                        <i class="bi bi-chevron-down text-sm"></i>
                    </button>
                    
                    <div class="user-menu absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-lg py-1 z-50"
                        x-show="open"
                        @click.away="open = false"
                        x-cloak
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95">
                        
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 hover:bg-gray-100 space-x-3">
                            <i class="bi bi-person"></i>
                            <span>Mon Profil</span>
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center px-4 py-3 hover:bg-gray-100 space-x-3">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Barre latérale -->
    <aside 
        class="w-64 bg-indigo-800 text-white fixed h-screen shadow-lg sidebar-transition"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        <div class="p-6 border-b border-indigo-700">
            <h2 class="text-xl font-bold">
                <i class="bi bi-tools mr-2"></i>
                Technicien
            </h2>
        </div>

        <nav class="mt-4 space-y-1">
            <a 
                href="{{ route('technician.dashboard') }}" 
                class="flex items-center px-4 py-3 hover:bg-indigo-700 space-x-3"
            >
                <i class="bi bi-clipboard-check"></i>
                <span>Mes Interventions</span>
            </a>
            
            <a 
                href="" 
                class="flex items-center px-4 py-3 hover:bg-indigo-700 space-x-3"
            >
                <i class="bi bi-calendar-event"></i>
                <span>Planning</span>
            </a>

            <div class="px-4 py-3">
                <div class="flex items-center justify-between">
                    <span>Disponibilité :</span>
                    <button 
                        x-data="{ available: {{ auth()->user()->available ? 'true' : 'false' }} }" 
                        @click="available = !available; $wire.setAvailability(available)"
                        :class="available ? 'bg-green-400' : 'bg-gray-400'" 
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors"
                    >
                        <span 
                            :class="available ? 'translate-x-6' : 'translate-x-1'" 
                            class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                        ></span>
                    </button>
                </div>
            </div>
        </nav>
    </aside>

    <!-- Contenu principal -->
    <main 
        class="ml-0 transition-all duration-300"
        :class="sidebarOpen ? 'lg:ml-64' : 'ml-0'"
    >
        <!-- Barre de navigation supérieure -->
        <nav class="bg-white shadow-sm fixed w-full z-40">
            <div class="flex justify-between items-center px-4 py-3">
                <button 
                    @click="sidebarOpen = !sidebarOpen"
                    class="text-gray-600 hover:text-indigo-600"
                >
                    <i class="bi bi-list text-2xl"></i>
                </button>
                
            </div>
        </nav>

        <!-- Contenu -->
        <div class="pt-16 px-4 min-h-screen">
            @yield('content')
        </div>
    </main>
</body>
</html>