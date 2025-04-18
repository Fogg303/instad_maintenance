<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    use HasFactory;
    protected $table = 'equipments';

    const STATUSES = [
        'new' => 'Neuf',
        'broken' => 'Défectueux',
        'repaired' => 'Réparé'
    ];
    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status] ?? 'Inconnu';
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'new' => 'bg-green-100 text-green-800',
            'broken' => 'bg-red-100 text-red-800',
            'repaired' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    protected $fillable = [
        'name', 
        'code',
        'status',
        'acquisition_date',
        'type_id',
        'user_id',
        'photo_path'
    ];

    protected $casts = [
        'acquisition_date' => 'date'
    ];

    protected static function booted()
    {
        static::creating(function ($equipment) {
            $equipment->code = self::generateUniqueCode();
        });

        static::deleting(function ($equipment) {
            Storage::disk('public')->delete($equipment->photo_path);
            $equipment->characteristicValues()->delete();
        });
    }

    public static function generateUniqueCode()
    {
        $prefix = 'EQ-';
        $latest = self::where('code', 'like', $prefix.'%')->latest()->first();
        $number = $latest ? (int) str_replace($prefix, '', $latest->code) + 1 : 1;
        return $prefix . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    public static function validationRules($id = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:equipment_types,id',
            'status' => 'required|in:' . implode(',', array_keys(self::STATUSES)),
            'acquisition_date' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'characteristics' => 'required|array',
            'characteristics.*' => [
                'required',
                function ($attribute, $value, $fail) {
                    $charId = (int) str_replace('characteristics.', '', $attribute);
                    $characteristic = Characteristic::find($charId);
                    
                    $rules = match($characteristic->data_type) {
                        'number' => 'numeric',
                        'boolean' => 'boolean',
                        'date' => 'date',
                        default => 'string|max:255'
                    };

                    $validator = Validator::make([$attribute => $value], [$attribute => $rules]);
                    
                    if ($validator->fails()) {
                        $fail("Format invalide pour {$characteristic->name} ({$characteristic->data_type})");
                    }
                }
            ]
        ];
    }

    // Relations
    public function type(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function characteristicValues(): HasMany
    {
        return $this->hasMany(EquipmentCharacteristicValue::class);
    }

    // Accesseurs
    public function getPhotoUrlAttribute()
    {
        return $this->photo_path ? Storage::url($this->photo_path) : asset('images/default-equipment.png');
    }
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function scopeFilter($query, $search)
{
    return $query->when($search, function($q) use ($search) {
        $q->where(function($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('code', 'like', "%$search%")
                ->orWhereHas('type', fn($q) => $q->where('name', 'like', "%$search%"))
                ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%$search%"));
        });
    });
}
}