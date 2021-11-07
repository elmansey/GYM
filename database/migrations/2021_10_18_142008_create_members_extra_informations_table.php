<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersExtraInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_extra_informations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->references('id')->on('users')->cascadeOnDelete();
            $table->text('interested_area')->nullable();
            $table->string('source')->nullable();
            $table->foreignId('membership_id')->references('id')->on('memberships')->cascadeOnDelete();
            $table->foreignId('group_id')->references('id')->on('groups')->cascadeOnDelete();
            $table->foreignId('class_id')->references('id')->on('class_schedules')->cascadeOnDelete();
            $table->date('start_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members_extra_informations');
    }
}
