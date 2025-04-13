<!DOCTYPE html>
<html lang="fr" x-data="{ isMenuOpen: false }">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Tableau de bord Technicien - INSTAD</title>

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
                        techPrimary: '#3B82F6',
                        techSecondary: '#60A5FA',
                        techDark: '#1E293B'
                    }
                }
            }
        };
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .tech-menu {
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">

    <!-- Top Navigation -->
    <nav class="bg-techPrimary text-white shadow-lg fixed w-full z-50">
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
                <div class="relative group">
                    <button class="flex items-center space-x-2 focus:outline-none">
                        <i class="bi bi-bell text-xl"></i>
                        <span class="bg-red-500 text-xs px-2 py-1 rounded-full">3</span>
                    </button>
                </div>
                
                <!-- Menu Technicien -->
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
                        class="tech-menu absolute right-0 mt-2 w-48 bg-white text-gray-800 rounded-lg py-1 z-50"
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

    <!-- Sidebar Technicien -->
    <aside id="sidebar" class="w-64 bg-techDark text-white fixed h-screen shadow-lg transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-40">
        <div class="p-6 text-xl font-bold border-b border-techPrimary">Menu Technicien</div>
        <nav class="mt-4 space-y-1">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 hover:bg-techPrimary space-x-3">
                <i class="bi bi-speedometer2"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="" class="flex items-center px-4 py-3 hover:bg-techPrimary space-x-3">
                <i class="bi bi-tools"></i>
                <span>Mes Interventions</span>
            </a>
            <a href="" class="flex items-center px-4 py-3 hover:bg-techPrimary space-x-3">
                <i class="bi bi-calendar-week"></i>
                <span>Planning</span>
            </a>
            <a href="" class="flex items-center px-4 py-3 hover:bg-techPrimary space-x-3">
                <i class="bi bi-pc-display"></i>
                <span>Équipements</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-64 pt-20 px-4 min-h-screen">
        <div class="py-6">
            <!-- Statistiques Technicien -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-techPrimary">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">Interventions en cours</p>
                            <p class="text-3xl font-bold">5</p>
                        </div>
                        <i class="bi bi-inboxes text-2xl text-techPrimary"></i>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">Taux de résolution</p>
                            <p class="text-3xl font-bold">92%</p>
                        </div>
                        <i class="bi bi-check2-circle text-2xl text-green-500"></i>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-orange-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">Temps moyen</p>
                            <p class="text-3xl font-bold">2h15</p>
                        </div>
                        <i class="bi bi-clock-history text-2xl text-orange-500"></i>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-purple-500">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500">Satisfaction</p>
                            <p class="text-3xl font-bold">4.8/5</p>
                        </div>
                        <i class="bi bi-emoji-smile text-2xl text-purple-500"></i>
                    </div>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="text-lg font-semibold mb-4">Charge de travail</h3>
                    <canvas id="workloadChart"></canvas>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="text-lg font-semibold mb-4">Types d'interventions</h3>
                    <canvas id="interventionTypesChart"></canvas>
                </div>
            </div>

            <!-- Dernières interventions -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Interventions récentes</h3>
                    <div class="flex space-x-2">
                        <button class="bg-techPrimary text-white px-4 py-2 rounded-lg">
                            <i class="bi bi-plus-lg mr-2"></i>Nouveau rapport
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left">N° Ticket</th>
                                <th class="px-6 py-3 text-left">Équipement</th>
                                <th class="px-6 py-3 text-left">Priorité</th>
                                <th class="px-6 py-3 text-left">Statut</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr>
                                <td class="px-6 py-4">#TECH-045</td>
                                <td class="px-6 py-4">Serveur Principal</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm">Critique</span>
                                </td>
                                <td class="px-6 py-4">
                                    <select class="border rounded px-2 py-1 text-sm bg-techPrimary text-white">
                                        <option>En cours</option>
                                        <option>Terminé</option>
                                        <option>En attente</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4">
                                    <button class="text-techPrimary hover:text-techSecondary">
                                        <i class="bi bi-journal-text"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Graphique de charge de travail
        const workloadChart = new Chart(document.getElementById('workloadChart'), {
            type: 'bar',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven'],
                datasets: [{
                    label: 'Heures travaillées',
                    data: [6, 5, 4, 7, 3],
                    backgroundColor: '#3B82F6'
                }]
            }
        });

        // Graphique types d'interventions
        const typeChart = new Chart(document.getElementById('interventionTypesChart'), {
            type: 'doughnut',
            data: {
                labels: ['Hardware', 'Software', 'Réseau'],
                datasets: [{
                    data: [12, 19, 8],
                    backgroundColor: ['#3B82F6', '#10B981', '#F59E0B']
                }]
            }
        });
    </script>
</body>
</html>