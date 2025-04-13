<form method="post" action="{{ route('profile.update') }}" class="space-y-4">
    @csrf
    @method('patch')

    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-instadBlue"
               required autofocus>
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-instadBlue"
               required>
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-4 text-sm text-gray-600">
                <p>{{ __('Votre adresse email n\'est pas vérifiée.') }}</p>
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="text-instadBlue hover:underline">
                        {{ __('Renvoyer l\'email de vérification') }}
                    </button>
                </form>
                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-green-600">
                        {{ __('Un nouveau lien de vérification a été envoyé.') }}
                    </p>
                @endif
            </div>
        @endif
    </div>

    <div class="flex items-center gap-4 mt-6">
        <button type="submit" class="px-4 py-2 bg-instadBlue text-white rounded-lg hover:bg-blue-700 transition-colors">
            Enregistrer les modifications
        </button>
        
        @if (session('status') === 'profile-updated')
            <span class="text-sm text-green-600" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                ✔ Enregistré
            </span>
        @endif
    </div>
</form>