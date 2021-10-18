<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersContactInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_contact_informations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->references('id')->on('members_personal_informations')->cascadeOnDelete();
            $table->string('address');
            $table->string('city');
            $table->string('phone_number');
            $table->string('email')->unique();
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
        Schema::dropIfExists('members_contact_informations');
    }
}
