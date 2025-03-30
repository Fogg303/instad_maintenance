<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasFactory;

    // Définir les champs que l'on peut remplir
    protected $fillable = [
        'name'
    ];

    // Définir la relation avec la table 'users'
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
