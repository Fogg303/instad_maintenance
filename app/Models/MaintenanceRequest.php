<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    // Définir les champs que l'on peut remplir
    protected $fillable = [
        'description',
        'priority',
        'status',
        'equipment_id',
        'user_id',
        'technician_id'
    ];

    // Définir la relation avec la table 'equipments'
    public function equipment()
    {
        return $this->belongsTo(Equipement::class);
    }

    // Définir la relation avec la table 'users' pour le demandeur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Définir la relation avec la table 'users' pour le technicien
    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
