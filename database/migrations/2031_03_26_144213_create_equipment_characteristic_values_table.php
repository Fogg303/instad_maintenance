<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('equipment_characteristic_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipments');
            $table->foreignId('characteristic_id')->constrained();
            $table->string('string_value')->nullable();
            $table->decimal('numeric_value', 10, 2)->nullable();
            $table->boolean('boolean_value')->nullable();
            $table->date('date_value')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_characteristic_values');
    }
};
