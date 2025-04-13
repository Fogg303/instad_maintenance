<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Inscription - INSTAD</title>

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
                        techDark: '#1E293B'
                    }
                }
            }
        };
    </script>

    <style>
        body {
            background: linear-gradient(135deg, #1E293B 0%, #3B82F6 100%);
            font-family: 'Inter', sans-serif;
        }
        .auth-card {
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        .form-input:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="auth-card bg-white p-8">
            <div class="text-center mb-8">
                <img src="{{ asset('assets/img/instad-logo.jpg') }}" alt="INSTAD Logo" class="h-12 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Créer un compte</h2>
                <p class="text-gray-600">Rejoignez notre plateforme technique</p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-700">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-person text-gray-400"></i>
                        </div>
                        <input id="name" type="text" name="name" required autofocus
                            class="form-input pl-10 block w-full rounded-lg border-gray-300 focus:border-techPrimary"
                            placeholder="Votre nom">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-envelope text-gray-400"></i>
                        </div>
                        <input id="email" type="email" name="email" required
                            class="form-input pl-10 block w-full rounded-lg border-gray-300 focus:border-techPrimary"
                            placeholder="email@exemple.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-lock text-gray-400"></i>
                        </div>
                        <input id="password" type="password" name="password" required
                            class="form-input pl-10 block w-full rounded-lg border-gray-300 focus:border-techPrimary"
                            placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-lock-fill text-gray-400"></i>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="form-input pl-10 block w-full rounded-lg border-gray-300 focus:border-techPrimary"
                            placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-white bg-techPrimary hover:bg-techSecondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-techPrimary">
                        S'inscrire
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Vous avez déjà un compte? 
                    <a href="{{ route('login') }}" class="font-medium text-techPrimary hover:text-techSecondary">
                        Connectez-vous
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>