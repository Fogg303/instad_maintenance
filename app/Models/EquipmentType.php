<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipementType extends Model
{
    use HasFactory;

    // Définir les champs que l'on peut remplir
    protected $fillable = [
        'name'
    ];

    // Définir la relation avec la table 'equipments'
    public function equipments()
    {
        return $this->hasMany(Equipement::class);
    }

    // Définir la relation avec la table 'characteristics'
    public function characteristics()
    {
        return $this->hasMany(Characteristic::class);
    }
}
