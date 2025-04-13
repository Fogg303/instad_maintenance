@component('mail::message')
# Bienvenue sur INSTAD !

Voici vos identifiants de connexion :

- **Email:** {{ $user->email }}
- **Mot de passe temporaire:** {{ $password }}

@component('mail::button', ['url' => route('login')])
Se connecter maintenant
@endcomponent

**Sécurité:** Changez votre mot de passe après la première connexion.

Merci,<br>
{{ config('app.name') }}
@endcomponent