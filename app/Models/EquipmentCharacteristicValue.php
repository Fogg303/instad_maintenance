<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentCharacteristicValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'characteristic_id',
        'string_value', 
        'numeric_value',
        'boolean_value',
        'date_value'
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function characteristic()
    {
        return $this->belongsTo(Characteristic::class);
    }
}