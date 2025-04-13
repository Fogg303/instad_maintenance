<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Déterminer si l'utilisateur est autorisé à faire cette requête
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->user()->id],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ];
    }

    /**
     * Messages de validation personnalisés
     */
    public function messages(): array
    {
        return [
            'current_password.current_password' => 'Le mot de passe actuel est incorrect',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas',
        ];
    }
}