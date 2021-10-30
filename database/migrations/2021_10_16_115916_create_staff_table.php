<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->uuid('Personal_uuid')->unique()->nullable();
            $table->string('firstName');
            $table->string('middleName');
            $table->string('lastName');
            $table->string('phone');
            $table->string('email')->nullable()->unique();
            $table->string('userName')->nullable();
            $table->string('password')->nullable();
            $table->string('profile_picture')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('isActive');
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
        Schema::dropIfExists('staff');
    }
}
