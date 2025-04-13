<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification Email - INSTAD</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .verify-bg {
            background: linear-gradient(15deg, #1E3A8A 0%, #3B82F6 100%);
        }
        .card-shadow {
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="verify-bg min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-xl card-shadow p-8">
            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <img src="{{ asset('assets/img/instad-logo.jpg') }}" alt="INSTAD Logo" class="h-16">
            </div>

            <!-- Contenu -->
            <div class="space-y-6">
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-indigo-600 mb-2">
                        <i class="bi bi-envelope-check mr-2"></i>Vérification de l'email
                    </h3>
                    <p class="text-gray-600">
                        {{ __('Merci pour votre inscription ! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous vous avons envoyé.') }}
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                        {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}" class="text-center">
                    @csrf
                    <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                        Renvoyer le lien de vérification
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="text-center">
                    @csrf
                    <button type="submit" class="text-indigo-600 hover:text-indigo-800 font-medium">
                        Se déconnecter
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>