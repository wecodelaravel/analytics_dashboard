<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Create5b592150ceb56ClinicUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('clinic_user')) {
            Schema::create('clinic_user', function (Blueprint $table) {
                $table->integer('clinic_id')->unsigned()->nullable();
                $table->foreign('clinic_id', 'fk_p_135004_134992_user_c_5b592150cecfa')->references('id')->on('clinics')->onDelete('cascade');
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', 'fk_p_134992_135004_clinic_5b592150cedee')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('clinic_user');
    }
}
