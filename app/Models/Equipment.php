<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
    use HasFactory;

    // Définir les champs que l'on peut remplir
    protected $fillable = [
        'name',
        'code',
        'status',
        'acquisition_date',
        'type_id',
        'user_id'
    ];

    // Définir la relation avec la table 'equipement_types'
    public function type()
    {
        return $this->belongsTo(EquipementType::class, 'type_id');
    }

    // Définir la relation avec la table 'users'
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Définir la relation avec la table 'maintenance_requests'
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    // Définir la relation avec la table 'equipment_characteristic_values'
    public function characteristicValues()
    {
        return $this->hasMany(EquipmentCharacteristicValue::class);
    }
}
