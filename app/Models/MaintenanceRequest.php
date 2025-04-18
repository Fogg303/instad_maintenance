<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    // Priorités
    public const PRIORITY_BASSE = 'basse';
    public const PRIORITY_MOYENNE = 'moyenne';
    public const PRIORITY_HAUTE = 'haute';

    // Statuts
    public const STATUS_OUVERT = 'ouvert';
    public const STATUS_EN_COURS = 'en_cours';
    public const STATUS_TERMINE = 'termine';
    public const STATUS_ANNULE = 'annule';

    protected $fillable = [
        'description',
        'priority',
        'status',
        'equipment_id',
        'user_id',
        'technician_id'
    ];

    // Tableau des priorités
    public static $priorities = [
        self::PRIORITY_BASSE => 'Basse',
        self::PRIORITY_MOYENNE => 'Moyenne',
        self::PRIORITY_HAUTE => 'Haute'
    ];

    // Tableau des statuts
    public static $statuses = [
        self::STATUS_OUVERT => 'Ouvert',
        self::STATUS_EN_COURS => 'En cours',
        self::STATUS_TERMINE => 'Terminé',
        self::STATUS_ANNULE => 'Annulé'
    ];

    // Accesseurs
    public function getPriorityLabelAttribute()
    {
        return self::$priorities[$this->priority] ?? 'Inconnue';
    }

    public function getStatusLabelAttribute()
    {
        return self::$statuses[$this->status] ?? 'Inconnu';
    }

    public function getPriorityClassAttribute()
    {
        return match($this->priority) {
            self::PRIORITY_BASSE => 'bg-blue-100 text-blue-800',
            self::PRIORITY_MOYENNE => 'bg-yellow-100 text-yellow-800',
            self::PRIORITY_HAUTE => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Relations
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}