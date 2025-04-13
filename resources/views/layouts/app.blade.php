<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - INStaD')</title>
    
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
    <!-- Navigation -->
    <nav class="bg-indigo-600 p-4">
        <div class="flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="text-white text-lg font-semibold">INStaD Maintenance</a>
            <button @click="sidebarOpen = !sidebarOpen" class="text-white lg:hidden">
                <i class="fas fa-bars"></i>
            </button>
            <div class="hidden lg:flex space-x-4">
                <a href="{{ route('profile.edit') }}" class="text-white hover:bg-indigo-700 p-2 rounded">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-white hover:bg-indigo-700 p-2 rounded">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div x-data="{ sidebarOpen: false }">
        <div class="lg:flex hidden">
            <nav class="bg-indigo-700 w-64 space-y-6 py-6 px-4">
                <div class="text-white font-semibold">Dashboard</div>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="text-white hover:bg-indigo-600 p-2 rounded">Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.directions.index') }}" class="text-white hover:bg-indigo-600 p-2 rounded">Manage Directions</a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Mobile Menu -->
        <div x-show="sidebarOpen" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-50" @click="sidebarOpen = false"></div>
        <div x-show="sidebarOpen" class="lg:hidden fixed top-0 left-0 bg-indigo-700 w-64 h-full p-4 z-50">
            <div class="text-white font-semibold">Dashboard</div>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="text-white hover:bg-indigo-600 p-2 rounded">Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('admin.directions.index') }}" class="text-white hover:bg-indigo-600 p-2 rounded">Manage Directions</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 bg-gray-100 p-6">
        <div class="container mx-auto">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-200 py-4 mt-6">
        <div class="container mx-auto text-center text-gray-500">
            <p>&copy; 2023 INStaD - All Rights Reserved</p>
        </div>
    </footer>
</body>
</html>
