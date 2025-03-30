<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être attribués en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Ajout du champ pour les rôles (admin, technician, user)
        'direction_id' // Ajout de la relation avec la table direction
    ];

    /**
     * Les attributs à masquer lors de la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs à convertir.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        
    ];

    /**
     * Définir la relation avec la table 'directions'
     */
    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    /**
     * Définir la relation avec la table 'equipements'
     */
    public function equipments()
    {
        return $this->hasMany(Equipement::class);
    }

    /**
     * Définir la relation avec la table 'maintenance_requests'
     */
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    /**
     * Définir la relation avec la table 'maintenance_requests' pour les techniciens assignés
     */
    public function assignedMaintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'technician_id');
    }
}


