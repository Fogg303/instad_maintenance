<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentCharacteristicValue extends Model
{
    use HasFactory;

    // Définir les champs que l'on peut remplir
    protected $fillable = [
        'equipment_id',
        'characteristic',
        'value'
    ];

    // Définir la relation avec la table 'equipments'
    public function equipment()
    {
        return $this->belongsTo(Equipement::class);
    }

    // Définir la relation avec la table 'characteristics'
    public function characteristic()
    {
        return $this->belongsTo(Characteristic::class, 'characteristic');
    }
}
