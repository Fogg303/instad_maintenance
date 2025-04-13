<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model // Correction du nom
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'status',
        'acquisition_date',
        'type_id',
        'user_id'
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class, 'type_id'); // Nom corrigé
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function characteristicValues(): HasMany
    {
        return $this->hasMany(EquipmentCharacteristicValue::class);
    }
}