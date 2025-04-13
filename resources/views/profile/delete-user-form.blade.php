<div x-data="{ showModal: false }">
    <button 
        @click="showModal = true"
        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2"
    >
        <i class="bi bi-trash3"></i>
        Supprimer le compte
    </button>

    <!-- Modal -->
    <div 
        x-show="showModal" 
        class="fixed inset-0 bg-black/50 flex items-center justify-center p-4"
        x-transition:enter="duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
    >
        <div class="bg-white rounded-xl p-6 max-w-md w-full">
            <h3 class="text-lg font-bold mb-4">Confirmer la suppression</h3>
            
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <p class="mb-4 text-gray-600">
                    Cette action est irréversible. Veuillez entrer votre mot de passe pour confirmer.
                </p>

                <div class="space-y-4">
                    <div>
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Votre mot de passe"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg"
                            required
                        >
                        @error('password', 'userDeletion')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <button 
                            type="button"
                            @click="showModal = false"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700"
                        >
                            Annuler
                        </button>
                        <button 
                            type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-700"
                        >
                            Confirmer la suppression
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>