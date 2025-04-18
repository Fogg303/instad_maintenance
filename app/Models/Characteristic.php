<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'default_value',
        'type_id'
    ];

    // Ajouter cette propriété pour inclure data_type dans les réponses JSON
    protected $appends = ['data_type'];

    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class, 'type_id');
    }

    public function values()
    {
        return $this->hasMany(EquipmentCharacteristicValue::class, 'characteristic_id');
    }

    // Déterminer le type de données dynamiquement
    public function getDataTypeAttribute()
    {
        $value = $this->default_value;

        if (is_numeric($value)) {
            return 'number';
        } elseif ($value === 'true' || $value === 'false') {
            return 'boolean';
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return 'date';
        } else {
            return 'string';
        }
    }

    // Garder la méthode existante pour le formatage
    public function getFormattedDefaultAttribute()
    {
        return match(true) {
            is_numeric($this->default_value) => (float)$this->default_value,
            $this->default_value === 'true' || $this->default_value === 'false' => (bool)$this->default_value,
            default => $this->default_value
        };
    }
}