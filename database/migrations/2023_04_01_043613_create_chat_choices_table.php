<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatChoicesTable extends Migration {
    public function up(): void
    {
        Schema::create('chat_choices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id');

            $table->integer('index');
            $table->enum('role', ['system', 'user']);
            $table->tinyText('content');
            $table->string('finish_reason')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_choices');
    }
};
