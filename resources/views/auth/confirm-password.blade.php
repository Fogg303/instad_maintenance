<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Confirmation - INSTAD</title>

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
                <h2 class="text-2xl font-bold text-gray-800">Confirmation requise</h2>
                <p class="text-gray-600">Veuillez confirmer votre mot de passe pour continuer</p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf

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
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-white bg-techPrimary hover:bg-techSecondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-techPrimary">
                        Confirmer
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>