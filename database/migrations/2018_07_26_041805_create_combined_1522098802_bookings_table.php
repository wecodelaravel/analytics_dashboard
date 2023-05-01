<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCombined1522098802BookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('bookings')) {
            Schema::create('bookings', function (Blueprint $table) {
                $table->increments('id');
                $table->string('customername')->nullable();
                $table->string('phone')->nullable();
                $table->string('family_number')->nullable();
                $table->string('email')->nullable();
                $table->string('how_long')->nullable();
                $table->string('requested_date')->nullable();
                $table->string('requested_time')->nullable();
                $table->string('requested_clinic')->nullable();
                $table->string('clinic_id')->nullable();
                $table->string('clinic_email')->nullable();
                $table->string('clinic_address')->nullable();
                $table->string('clinic_phone')->nullable();
                $table->string('clinic_text_numbers')->nullable();
                $table->string('client_firstname')->nullable();
                $table->string('submitted_user_city')->nullable();
                $table->string('submitted_user_state')->nullable();
                $table->string('searched_for')->nullable();
                $table->string('latitude')->nullable();
                $table->string('longitude')->nullable();
                $table->string('country')->nullable();
                $table->string('submitted')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->index(['deleted_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
