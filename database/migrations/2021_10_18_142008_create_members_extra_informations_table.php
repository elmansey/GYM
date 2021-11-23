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
            $table->string('phone');
            $table->foreignId('membership_id')->references('id')->on('memberships')->cascadeOnDelete();
            $table->string('group_id');
            $table->string('class_id');
            $table->string('payment');
            $table->date('start_date');
            $table->date('period_Expiry')->nullable();
            $table->string('Subscription_period')->nullable();
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('address');
            $table->string('membership_price');
            $table->string('city');
            $table->string('profile_picture')->nullable();
            $table->string('source')->nullable();
            $table->string('Account_freeze')->nullable();
            $table->string('unFreeze_in')->nullable();
            $table->string('days_left_before_freezing')->nullable();
            $table->string('total_payment')->nullable();
            $table->json('log')->nullable();
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
