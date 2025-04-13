<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
// Dans le fichier de migration
        public function up()
        {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('force_password_change')->default(true);
                // Ou : $table->timestamp('password_changed_at')->nullable();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
