<!DOCTYPE html>
<html lang="fr" x-data="{ isMenuOpen: false }">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Tableau de bord Utilisateur - INSTAD</title>

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
                <div class="relative group" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <i class="bi bi-bell text-xl"></i>
                        <span class="badge-new absolute -top-1 -right-1 bg-red-500 text-xs px-2 py-1 rounded-full">3</span>
                    </button>
                    
                    <!-- Notifications Dropdown -->
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
                        
                        <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-100 space-x-3">
                            <div class="bg-blue-100 p-2 rounded-full">
                                <i class="bi bi-tools text-userPrimary"></i>
                            </div>
                            <div>
                                <p class="text-sm">Votre ticket #TICK-125 a été pris en charge</p>
                                <p class="text-xs text-gray-500">Il y a 2 heures</p>
                            </div>
                        </a>
                        
                        <a href="#" class="flex items-center px-4 py-3 hover:bg-gray-100 space-x-3">
                            <div class="bg-green-100 p-2 rounded-full">
                                <i class="bi bi-check-circle text-green-500"></i>
                            </div>
                            <div>
                                <p class="text-sm">Votre demande #TICK-118 a été résolue</p>
                                <p class="text-xs text-gray-500">Hier, 14:30</p>
                            </div>
                        </a>
                        
                        <div class="px-4 py-2 border-t text-center">
                            <a href="#" class="text-sm text-userPrimary hover:text-userSecondary">Voir toutes les notifications</a>
                        </div>
                    </div>
                </div>
                
                <!-- User Menu -->
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

    <!-- Sidebar User -->
    <aside id="sidebar" 
           class="w-64 bg-userDark text-white fixed h-screen shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-40"
           :class="{ 'translate-x-0': isMenuOpen }"
           @click.away="isMenuOpen = false">
        <div class="p-6 text-xl font-bold border-b border-userPrimary">Menu Utilisateur</div>
        <nav class="mt-4 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 hover:bg-userPrimary space-x-3">
                <i class="bi bi-speedometer2"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 hover:bg-userPrimary space-x-3">
                <i class="bi bi-ticket-detailed"></i>
                <span>Mes Tickets</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 hover:bg-userPrimary space-x-3">
                <i class="bi bi-plus-circle"></i>
                <span>Nouvelle Demande</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 hover:bg-userPrimary space-x-3">
                <i class="bi bi-pc-display"></i>
                <span>Mes Équipements</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 hover:bg-userPrimary space-x-3">
                <i class="bi bi-chat-left-text"></i>
                <span>Messagerie</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-64 pt-20 px-4 min-h-screen">
        <div class="py-6">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-userPrimary to-userSecondary text-white p-6 rounded-xl shadow-sm mb-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold">Bonjour, {{ Auth::user()->name }} !</h2>
                        <p class="mt-2">Comment pouvons-nous vous aider aujourd'hui ?</p>
                    </div>
                    <a href="#" class="mt-4 md:mt-0 bg-white text-userPrimary px-6 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                        <i class="bi bi-plus-lg mr-2"></i>Nouvelle demande
                    </a>
                </div>
            </div>

            <!-- Statistiques Utilisateur -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-userPrimary">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">Tickets ouverts</p>
                            <p class="text-3xl font-bold">3</p>
                        </div>
                        <i class="bi bi-ticket-detailed text-2xl text-userPrimary"></i>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">Tickets résolus</p>
                            <p class="text-3xl font-bold">12</p>
                        </div>
                        <i class="bi bi-check2-circle text-2xl text-green-500"></i>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">En attente</p>
                            <p class="text-3xl font-bold">2</p>
                        </div>
                        <i class="bi bi-clock text-2xl text-yellow-500"></i>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-purple-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">Satisfaction</p>
                            <p class="text-3xl font-bold">4.5/5</p>
                        </div>
                        <i class="bi bi-emoji-smile text-2xl text-purple-500"></i>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <a href="#" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:border-userPrimary transition group">
                    <div class="flex items-center space-x-4">
                        <div class="bg-userLight p-3 rounded-lg group-hover:bg-userPrimary group-hover:text-white text-userPrimary">
                            <i class="bi bi-plus-lg text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-medium">Nouveau Ticket</h3>
                            <p class="text-sm text-gray-500">Signaler un problème</p>
                        </div>
                    </div>
                </a>
                
                <a href="#" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:border-green-500 transition group">
                    <div class="flex items-center space-x-4">
                        <div class="bg-green-50 p-3 rounded-lg group-hover:bg-green-500 group-hover:text-white text-green-500">
                            <i class="bi bi-search text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-medium">Base de connaissances</h3>
                            <p class="text-sm text-gray-500">Solutions en libre accès</p>
                        </div>
                    </div>
                </a>
                
                <a href="#" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:border-blue-500 transition group">
                    <div class="flex items-center space-x-4">
                        <div class="bg-blue-50 p-3 rounded-lg group-hover:bg-blue-500 group-hover:text-white text-blue-500">
                            <i class="bi bi-pc-display-horizontal text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-medium">Mes Équipements</h3>
                            <p class="text-sm text-gray-500">Liste de vos appareils</p>
                        </div>
                    </div>
                </a>
                
                <a href="#" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:border-purple-500 transition group">
                    <div class="flex items-center space-x-4">
                        <div class="bg-purple-50 p-3 rounded-lg group-hover:bg-purple-500 group-hover:text-white text-purple-500">
                            <i class="bi bi-chat-left-text text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-medium">Messagerie</h3>
                            <p class="text-sm text-gray-500">Contactez le support</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Derniers Tickets -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Mes Demandes Récentes</h3>
                    <a href="#" class="text-sm text-userPrimary hover:text-userSecondary">Voir tout</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left">N° Ticket</th>
                                <th class="px-6 py-3 text-left">Sujet</th>
                                <th class="px-6 py-3 text-left">Statut</th>
                                <th class="px-6 py-3 text-left">Date</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr>
                                <td class="px-6 py-4 font-medium">#USER-125</td>
                                <td class="px-6 py-4">Problème d'impression</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">En cours</span>
                                </td>
                                <td class="px-6 py-4">15/06/2024</td>
                                <td class="px-6 py-4">
                                    <button class="text-userPrimary hover:text-userSecondary mr-3">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="text-gray-500 hover:text-gray-700">
                                        <i class="bi bi-chat-left-text"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 font-medium">#USER-118</td>
                                <td class="px-6 py-4">Accès au réseau</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">Résolu</span>
                                </td>
                                <td class="px-6 py-4">10/06/2024</td>
                                <td class="px-6 py-4">
                                    <button class="text-userPrimary hover:text-userSecondary mr-3">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="text-gray-500 hover:text-gray-700">
                                        <i class="bi bi-chat-left-text"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Équipements -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Mes Équipements</h3>
                    <a href="#" class="text-sm text-userPrimary hover:text-userSecondary">Voir tout</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                    <div class="border rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex items-center space-x-4">
                            <div class="bg-userLight p-3 rounded-lg text-userPrimary">
                                <i class="bi bi-pc-display text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">PC Portable - Dell XPS</h4>
                                <p class="text-sm text-gray-500">SN: DXP-4587-9654</p>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between text-sm">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Actif</span>
                            <a href="#" class="text-userPrimary hover:text-userSecondary">Détails</a>
                        </div>
                    </div>
                    
                    <div class="border rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex items-center space-x-4">
                            <div class="bg-blue-50 p-3 rounded-lg text-blue-500">
                                <i class="bi bi-phone text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Smartphone - iPhone 13</h4>
                                <p class="text-sm text-gray-500">SN: IPH-1325-8741</p>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between text-sm">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded">Actif</span>
                            <a href="#" class="text-userPrimary hover:text-userSecondary">Détails</a>
                        </div>
                    </div>
                    
                    <div class="border rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex items-center space-x-4">
                            <div class="bg-purple-50 p-3 rounded-lg text-purple-500">
                                <i class="bi bi-printer text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="font-medium">Imprimante - HP LaserJet</h4>
                                <p class="text-sm text-gray-500">SN: HPL-7854-1236</p>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between text-sm">
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">En maintenance</span>
                            <a href="#" class="text-userPrimary hover:text-userSecondary">Détails</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Script pour gérer le menu mobile
        document.addEventListener('DOMContentLoaded', function() {
            // Fermer le menu quand un lien est cliqué (sur mobile)
            const menuLinks = document.querySelectorAll('#sidebar nav a');
            menuLinks.forEach(link => {
                link.addEventListener('click', () => {
                    const sidebar = document.getElementById('sidebar');
                    if (window.innerWidth < 1024) {
                        sidebar.classList.add('-translate-x-full');
                    }
                });
            });
        });
    </script>
</body>
</html>