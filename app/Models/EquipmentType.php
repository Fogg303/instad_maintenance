<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipmentType extends Model // Nom corrigé
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description' // Ajout recommandé
    ];

    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class); // Nom corrigé
    }

    public function characteristics(): HasMany
    {
        return $this->hasMany(Characteristic::class)
            ->with('validationRules'); // Relation améliorée
    }
}