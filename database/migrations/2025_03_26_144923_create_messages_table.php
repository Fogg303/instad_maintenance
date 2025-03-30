<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id') // L'utilisateur qui envoie le message
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('receiver_id') // L'utilisateur qui reçoit le message
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->text('message'); // Le contenu du message
            $table->foreignId('maintenance_request_id') // Si le message est lié à une demande de maintenance
                  ->constrained('maintenance_requests')
                  ->onDelete('cascade');
            $table->timestamps(); // Date d'envoi du message
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
