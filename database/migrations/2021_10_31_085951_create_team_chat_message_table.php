<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamChatMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_chat_message', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('to')->references('id')->on('users')->cascadeOnDelete();
            $table->text('message');
            $table->boolean('read')->default(false);
            $table->string('send_at');
            $table->string('reading_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_chat_message');
    }
}
