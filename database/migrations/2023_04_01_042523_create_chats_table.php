<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration {
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('user_id')
                ->nullable();

            $table->string('token')
                ->nullable();
            $table->foreignId('chat_object_id');
            $table->foreignId('chat_model_id');
            $table->string('response_created')
                ->nullable();

            // $table->foreignId('token_usage_id');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
