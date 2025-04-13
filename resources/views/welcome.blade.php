<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Accueil - Plateforme Maintenance INSTAD</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        techPrimary: '#3B82F6',
                        techSecondary: '#60A5FA',
                        techDark: '#1E293B',
                        techLight: '#EFF6FF'
                    }
                }
            }
        };
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #1E293B;
        }
        .hero {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.9) 0%, rgba(59, 130, 246, 0.9) 100%), 
                        url('https://source.unsplash.com/1600x900/?technology,server,datacenter');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        .feature-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        .btn-primary {
            background-color: #3B82F6;
            border-color: #3B82F6;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2563EB;
            border-color: #2563EB;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="bg-white shadow-sm fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <img src="{{ asset('assets/img/instad-logo.jpg') }}" alt="INSTAD Logo" class="h-10">
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-techDark hover:text-techPrimary font-medium">Connexion</a>
                  
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero pt-16">
        <div class="max-w-4xl px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Plateforme de Maintenance Technique INSTAD</h1>
            <p class="text-xl md:text-2xl mb-8">Optimisez la gestion de votre parc informatique avec notre solution tout-en-un</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}" class="bg-white text-techPrimary px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition">Commencer</a>
                <a href="#features" class="bg-techSecondary text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-500 transition">En savoir plus</a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-techLight">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-techDark mb-12">Pourquoi choisir INSTAD ?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white p-8">
                    <div class="text-techPrimary mb-4">
                        <i class="bi bi-tools text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Gestion Centralisée</h3>
                    <p class="text-gray-600">Pilotez l'ensemble de votre parc matériel depuis une interface unique et intuitive.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card bg-white p-8">
                    <div class="text-techPrimary mb-4">
                        <i class="bi bi-shield-check text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Sécurité Maximale</h3>
                    <p class="text-gray-600">Protocoles de sécurité avancés pour protéger vos données sensibles.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card bg-white p-8">
                    <div class="text-techPrimary mb-4">
                        <i class="bi bi-graph-up text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Analyses en Temps Réel</h3>
                    <p class="text-gray-600">Tableaux de bord personnalisables pour un suivi précis de vos indicateurs.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-techDark mb-6">Prêt à révolutionner votre maintenance IT ?</h2>
            <p class="text-xl text-gray-600 mb-8">Rejoignez les centaines de techniciens qui nous font déjà confiance.</p>
              
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-techDark text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0">
                    <img src="{{ asset('assets/img/instad-logo.jpg') }}" alt="INSTAD Logo" class="h-10">
                    <p class="mt-4 text-gray-300">La solution tout-en-un pour la maintenance technique.</p>
                </div>
                <div class="flex flex-col items-center md:items-end">
                    <div class="flex space-x-6 mb-4">
                        <a href="#" class="text-gray-300 hover:text-white">
                            <i class="bi bi-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <i class="bi bi-linkedin text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <i class="bi bi-twitter-x text-xl"></i>
                        </a>
                    </div>
                    <div class="text-sm text-gray-400">
                        <p>&copy; 2025 INSTAD Maintenance. Tous droits réservés.</p>
                        <div class="mt-2">
                            <a href="#" class="hover:text-white">Confidentialité</a>
                            <span class="mx-2">•</span>
                            <a href="#" class="hover:text-white">Conditions</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>