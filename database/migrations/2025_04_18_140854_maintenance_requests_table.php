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
        Schema::table('maintenance_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('maintenance_requests', 'description')) {
                $table->text('description')->nullable();
            }

            if (!Schema::hasColumn('maintenance_requests', 'priority')) {
                $table->enum('priority', ['low', 'normal', 'high'])->default('normal');
            }

            if (!Schema::hasColumn('maintenance_requests', 'status')) {
                $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            }

            if (!Schema::hasColumn('maintenance_requests', 'equipment_id')) {
                $table->foreignId('equipment_id')->constrained('equipments')->cascadeOnDelete();
            }

            if (!Schema::hasColumn('maintenance_requests', 'user_id')) {
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            }

            if (!Schema::hasColumn('maintenance_requests', 'technician_id')) {
                $table->foreignId('technician_id')->nullable()->constrained('users')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_requests', function (Blueprint $table) {
            // Supprimer les colonnes ajoutées (attention à ne pas supprimer celles déjà utilisées ailleurs)
            if (Schema::hasColumn('maintenance_requests', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('maintenance_requests', 'priority')) {
                $table->dropColumn('priority');
            }

            if (Schema::hasColumn('maintenance_requests', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('maintenance_requests', 'equipment_id')) {
                $table->dropForeign(['equipment_id']);
                $table->dropColumn('equipment_id');
            }

            if (Schema::hasColumn('maintenance_requests', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            if (Schema::hasColumn('maintenance_requests', 'technician_id')) {
                $table->dropForeign(['technician_id']);
                $table->dropColumn('technician_id');
            }
        });
    }
};
