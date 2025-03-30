<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Dashboard for INSTAD Maintenance Platform" />
        <meta name="author" content="INSTAD Team" />
        <title>Admin Dashboard - INSTAD</title>

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <!-- Font Awesome -->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Custom CSS -->
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    </head>
    <body class="bg-gray-100 font-sans leading-normal tracking-normal">
        <!-- Top Navigation -->
        <nav class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 text-white shadow-lg">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <a href="#" class="text-2xl font-bold">INSTAD-BENIN</a>
                <div class="flex items-center space-x-4">
                    <span class="text-sm">Logged in as: <strong>{{ Auth::user()->name }}</strong></span>
                    <div class="relative">
                        <button class="focus:outline-none">
                            <i class="fas fa-user fa-fw"></i>
                        </button>
                        <ul class="absolute right-0 mt-2 w-48 bg-white text-gray-800 shadow-lg rounded-lg overflow-hidden">
                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-200">Settings</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-200">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar and Content -->
        <div class="flex">
            <!-- Sidebar -->
            <div class="w-64 bg-gradient-to-b from-blue-700 to-blue-900 text-white h-screen">
                <div class="p-4 text-lg font-bold border-b border-blue-500">Admin Menu</div>
                <ul class="mt-4 space-y-2">
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-blue-600 rounded">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-blue-600 rounded">
                            <i class="fas fa-users"></i> Manage Users
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-blue-600 rounded">
                            <i class="fas fa-desktop"></i> Manage Equipments
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-blue-600 rounded">
                            <i class="fas fa-tools"></i> Maintenance Requests
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-blue-600 rounded">
                            <i class="fas fa-chart-bar"></i> Reports
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="flex-1 p-6">
                <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

                <!-- Section: Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Users -->
                    <div class="bg-gradient-to-r from-blue-400 to-blue-600 text-white p-6 rounded-lg shadow-lg">
                        <h5 class="text-lg font-semibold">Total Users</h5>
                        <h2 class="text-4xl font-bold mt-2">123</h2>
                    </div>

                    <!-- Total Technicians -->
                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white p-6 rounded-lg shadow-lg">
                        <h5 class="text-lg font-semibold">Total Technicians</h5>
                        <h2 class="text-4xl font-bold mt-2">45</h2>
                    </div>

                    <!-- Open Maintenance Requests -->
                    <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-6 rounded-lg shadow-lg">
                        <h5 class="text-lg font-semibold">Open Maintenance Requests</h5>
                        <h2 class="text-4xl font-bold mt-2">12</h2>
                    </div>

                    <!-- Completed Requests -->
                    <div class="bg-gradient-to-r from-red-400 to-red-600 text-white p-6 rounded-lg shadow-lg">
                        <h5 class="text-lg font-semibold">Completed Requests</h5>
                        <h2 class="text-4xl font-bold mt-2">30</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gradient-to-r from-blue-800 to-blue-900 text-white mt-6">
            <div class="container mx-auto px-4 py-4 flex justify-between items-center">
                <span>&copy; 2025 INSTAD. All rights reserved.</span>
                <div>
                    <a href="#" class="hover:underline">Privacy Policy</a>
                    &middot;
                    <a href="#" class="hover:underline">Terms & Conditions</a>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>