<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('affectations', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'affectation
            $table->foreignId('idDemande')->constrained('maintenance_requests')->onDelete('cascade'); // Demande de maintenance
            $table->foreignId('idTechnicien')->constrained('users')->onDelete('cascade'); // Technicien affecté
            $table->timestamp('dateAffectation')->nullable(); // Date de l'affectation
            $table->timestamp('date_debut')->nullable(); // Date de début de l'affectation
            $table->timestamp('date_fin')->nullable(); // Date de fin de l'affectation
            $table->enum('statut', ['en cours', 'terminée', 'annulée'])->default('en cours'); // Statut de l'affectation
            $table->enum('priorite', ['basse', 'normale', 'haute'])->default('normale'); // Priorité de l'affectation
            $table->text('commentaires')->nullable(); // Commentaires de l'affectation
            $table->integer('evaluation')->nullable(); // Évaluation de l'affectation
            $table->integer('progression')->default(0); // Pourcentage de progression
            $table->text('raison_annulation')->nullable(); // Raison de l'annulation
            $table->boolean('confirmation_prise_en_charge')->default(false); // Confirmation de la prise en charge
            $table->string('fichiers_joints')->nullable(); // Fichiers joints relatifs à l'affectation
            $table->boolean('assignation_temporaire')->default(false); // Indique si l'affectation est temporaire
            $table->timestamps(); // Timestamps pour la création et la mise à jour
        });
    }

    public function down()
    {
        Schema::dropIfExists('affectations');
    }
};
