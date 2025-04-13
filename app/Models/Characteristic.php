<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Characteristic extends Model
{
    use HasFactory;

    // Correction du nom de la clé étrangère
    protected $fillable = [
        'name',
        'default_value',
        'type_id' // Garder le nom cohérent avec la migration
    ];

    // Ajout des casts pour les types de données
    protected $casts = [
        'default_value' => 'json' // Pour stocker différents types de valeurs
    ];

    /**
     * Relation avec le type d'équipement
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipmentType(): BelongsTo
    {
        // Correction de l'orthographe de la classe
        return $this->belongsTo(EquipmentType::class, 'type_id');
    }

    /**
     * Relation avec les valeurs des caractéristiques
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characteristicValues(): HasMany
    {
        return $this->hasMany(EquipmentCharacteristicValue::class);
    }

    // Ajout d'un accesseur pour la valeur par défaut
    public function getFormattedDefaultValueAttribute()
    {
        return match($this->type) {
            'boolean' => (bool)$this->default_value,
            'integer' => (int)$this->default_value,
            'float' => (float)$this->default_value,
            default => $this->default_value
        };
    }
}