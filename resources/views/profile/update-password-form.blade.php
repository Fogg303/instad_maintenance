<form method="post" action="{{ route('password.update') }}" class="space-y-4">
    @csrf
    @method('put')

    <div>
        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel</label>
        <input type="password" id="current_password" name="current_password"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-instadBlue">
        @error('current_password', 'updatePassword')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
        <input type="password" id="password" name="password"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-instadBlue">
        @error('password', 'updatePassword')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmation</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-instadBlue">
    </div>

    <div class="flex items-center gap-4 mt-6">
        <button type="submit" class="px-4 py-2 bg-instadBlue text-white rounded-lg hover:bg-blue-700 transition-colors">
            Changer le mot de passe
        </button>

        @if (session('status') === 'password-updated'))
            <span class="text-sm text-green-600" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                ✔ Mot de passe mis à jour
            </span>
        @endif
    </div>
</form>