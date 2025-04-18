<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\Equipment;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Ajoutez cette Gate
        Gate::define('create-maintenance', function (User $user, Equipment $equipment) {
            return $user->id === $equipment->user_id 
                   && in_array($equipment->status, ['new', 'repaired']);
        });
    }
}
