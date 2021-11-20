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
            $table->uuid('Personal_uuid')->unique()->nullable();
            $table->text('interested_area')->nullable();
            $table->string('name');
            $table->string('qr_code')->nullable();
            $table->string('RF_code');
            $table->boolean('isActive');
            $table->string('phone');
            $table->foreignId('membership_id')->references('id')->on('memberships')->cascadeOnDelete();
            $table->foreignId('group_id')->nullable()->references('id')->on('groups')->cascadeOnDelete();
            $table->foreignId('class_id')->nullable()->references('id')->on('class_schedules')->cascadeOnDelete();
            $table->string('amount_paid');
            $table->string('Subscription_status')->nullable();
            $table->date('start_date');
            $table->date('period_Expiry')->nullable();
            $table->string('Subscription_period')->nullable();
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('address');
            $table->string('city');
            $table->string('profile_picture');
            $table->string('source')->nullable();
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
