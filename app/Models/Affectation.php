<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    use HasFactory;

    protected $fillable = [
        'idDemande',
        'idTechnicien',
        'dateAffectation',
        'date_debut',
        'date_fin',
        'statut',
        'priorite',
        'commentaires',
        'evaluation',
        'progression',
        'raison_annulation',
        'confirmation_prise_en_charge',
        'fichiers_joints',
        'assignation_temporaire',
    ];

    /**
     * Relation avec la demande de maintenance.
     */
    public function demandeMaintenance()
    {
        return $this->belongsTo(MaintenanceRequest::class, 'idDemande');
    }

    /**
     * Relation avec le technicien.
     */
    public function technicien()
    {
        return $this->belongsTo(User::class, 'idTechnicien');
    }
}
