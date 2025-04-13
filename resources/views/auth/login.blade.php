<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - INSTAD</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .login-bg {
            background: linear-gradient(15deg, #1E3A8A 0%, #3B82F6 100%);
        }
        .card-shadow {
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.2);
        }
        .input-focus:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
    </style>
</head>
<body class="login-bg min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-xl card-shadow p-8">
            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <img src="{{ asset('assets/img/instad-logo.jpg') }}" alt="INSTAD Logo" class="h-16">
            </div>

            <!-- Formulaire -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-envelope mr-2 text-indigo-600"></i>Adresse email
                    </label>
                    <input 
                        type="email" 
                        name="email"
                        required
                        class="w-full px-4 py-3 rounded-lg border input-focus placeholder-gray-400 @error('email') border-red-500 @enderror"
                        placeholder="exemple@instad.com">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-lock mr-2 text-indigo-600"></i>Mot de passe
                    </label>
                    <input 
                        type="password" 
                        name="password"
                        required
                        class="w-full px-4 py-3 rounded-lg border input-focus placeholder-gray-400 @error('password') border-red-500 @enderror"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Se souvenir de moi -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2">
                        <input 
                            type="checkbox" 
                            name="remember"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-gray-600">Se souvenir de moi</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                    <a 
                        href="{{ route('password.request') }}" 
                        class="text-sm text-indigo-600 hover:text-indigo-800">
                        Mot de passe oublié ?
                    </a>
                    @endif
                </div>

                <!-- Bouton de connexion -->
                <button 
                    type="submit" 
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                    Se connecter
                </button>
            </form>

            <!-- Lien d'inscription -->
            <!-- Remplacer la section inscription par -->
            @if(config('auth.allow_registration'))
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                        Créer un compte
                    </a>
                </p>
            </div>
            @endif
            <!-- Fin du lien d'inscription -->
        </div>
    </div>
</body>
</html>