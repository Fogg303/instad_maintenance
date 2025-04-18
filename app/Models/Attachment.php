<?php

// app/Models/Attachment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    protected $fillable = ['path', 'original_name'];

    // Relation vers la demande de maintenance
    public function maintenanceRequest()
    {
        return $this->belongsTo(MaintenanceRequest::class);
    }

    // Suppression automatique du fichier physique
    protected static function booted()
    {
        static::deleted(function ($attachment) {
            Storage::disk('public')->delete($attachment->path);
        });
    }

    // URL publique pour le téléchargement
    public function url()
    {
        return asset("storage/{$this->path}");
    }
}