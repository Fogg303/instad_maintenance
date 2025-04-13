<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changement mot de passe - INSTAD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .login-bg { background: linear-gradient(15deg, #1E3A8A 0%, #3B82F6 100%); }
        .card-shadow { box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.2); }
        .input-focus:focus { 
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .error-border { border-color: #EF4444; }
    </style>
</head>
<body class="login-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl card-shadow p-8">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="/assets/img/instad-logo.jpg" alt="INSTAD" class="h-14">
            </div>

            <!-- Titre -->
            <h2 class="text-xl font-bold text-gray-800 text-center mb-6">
                <i class="bi bi-shield-lock text-blue-600 mr-2"></i>
                Changement de mot de passe obligatoire
            </h2>

            <!-- Message d'alerte -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 mb-6 rounded">
                <div class="flex items-start">
                    <i class="bi bi-exclamation-triangle-fill mr-2 mt-0.5"></i>
                    <span>Pour votre sécurité, veuillez modifier votre mot de passe temporaire</span>
                </div>
            </div>

            <!-- Formulaire -->
            <form method="POST" action="/password/change" class="space-y-4">
                <!-- CSRF Token caché -->
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                <!-- Champ Mot de passe actuel -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="bi bi-key text-blue-600 mr-2"></i>
                        Mot de passe temporaire
                    </label>
                    <div class="relative">
                        <input type="password" name="current_password" required
                            class="w-full px-4 py-2.5 rounded-lg border input-focus placeholder-gray-400 <?php if($errors->has('current_password')) echo 'error-border'; ?>"
                            placeholder="Entrez votre mot de passe actuel">
                        <i class="bi bi-lock absolute right-3 top-3 text-gray-400"></i>
                    </div>
                    <?php if($errors->has('current_password')): ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo $errors->first('current_password'); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Champ Nouveau mot de passe -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="bi bi-shield-lock text-blue-600 mr-2"></i>
                        Nouveau mot de passe
                    </label>
                    <div class="relative">
                        <input type="password" name="password" required
                            class="w-full px-4 py-2.5 rounded-lg border input-focus placeholder-gray-400 <?php if($errors->has('password')) echo 'error-border'; ?>"
                            placeholder="Créez un nouveau mot de passe">
                        <i class="bi bi-eye-slash absolute right-3 top-3 text-gray-400 cursor-pointer toggle-password"></i>
                    </div>
                    <?php if($errors->has('password')): ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo $errors->first('password'); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Champ Confirmation -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="bi bi-check2-circle text-blue-600 mr-2"></i>
                        Confirmer le mot de passe
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" required
                            class="w-full px-4 py-2.5 rounded-lg border input-focus placeholder-gray-400"
                            placeholder="Confirmez votre nouveau mot de passe">
                        <i class="bi bi-eye-slash absolute right-3 top-3 text-gray-400 cursor-pointer toggle-password"></i>
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 rounded-lg font-medium transition-colors mt-4">
                    <i class="bi bi-save2 mr-2"></i>
                    Enregistrer les modifications
                </button>
            </form>
        </div>
    </div>

    <!-- Script pour basculer la visibilité du mot de passe -->
    <script>
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        });
    </script>
</body>
</html>