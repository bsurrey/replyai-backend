<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTokenUsagesTable extends Migration {
    public function up(): void
    {
        Schema::create('user_token_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('chat_id');

            $table->integer('tokens_prompt')
                ->default(0)
                ->nullable();
            $table->integer('tokens_completion')
                ->default(0)
                ->nullable();
            $table->integer('tokens_total')
                ->default(0)
                ->nullable();

            $table->boolean('from_api')
                ->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_tokens');
    }
};
