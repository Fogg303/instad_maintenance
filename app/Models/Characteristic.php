<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    use HasFactory;

    // Définir les champs que l'on peut remplir
    protected $fillable = [
        'name',
        'default_value',
        'type_id'
    ];

    // Définir la relation avec la table 'equipement_types'
    public function type()
    {
        return $this->belongsTo(EquipementType::class, 'type_id');
    }

    // Définir la relation avec la table 'equipment_characteristic_values'
    public function characteristicValues()
    {
        return $this->hasMany(EquipmentCharacteristicValue::class);
    }
}
