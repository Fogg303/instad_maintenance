<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/[...]_RefactorEquipmentCharacteristics.php
public function up()
{
    Schema::table('equipment_characteristic_values', function (Blueprint $table) {
        // Supprimer seulement si les colonnes existent
        if (Schema::hasColumn('equipment_characteristic_values', 'characteristic')) {
            $table->dropColumn('characteristic');
        }
        if (Schema::hasColumn('equipment_characteristic_values', 'value')) {
            $table->dropColumn('value');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment_characteristic_values', function (Blueprint $table) {
            //
        });
    }
};
