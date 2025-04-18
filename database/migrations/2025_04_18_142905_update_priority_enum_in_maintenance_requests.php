<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    DB::statement("ALTER TABLE maintenance_requests MODIFY priority ENUM('basse', 'moyenne', 'haute') DEFAULT 'moyenne'");
    DB::statement("ALTER TABLE maintenance_requests MODIFY status ENUM('ouvert', 'en_cours', 'termine', 'annule') DEFAULT 'ouvert'");
}

public function down(): void
{
    DB::statement("ALTER TABLE maintenance_requests MODIFY priority ENUM('low', 'normal', 'high') DEFAULT 'normal'");
    DB::statement("ALTER TABLE maintenance_requests MODIFY status ENUM('pending', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending'");
}

};
