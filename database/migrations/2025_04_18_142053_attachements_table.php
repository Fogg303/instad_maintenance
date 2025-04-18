<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       // database/migrations/[...]_create_attachments_table.php
Schema::create('attachments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('maintenance_request_id')
          ->constrained()
          ->cascadeOnDelete(); // Supprime les pièces jointes si la demande est effacée
    $table->string('path');    // Chemin de stockage (ex: 'attachments/1/fichier.pdf')
    $table->string('original_name'); // Nom original du fichier
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};