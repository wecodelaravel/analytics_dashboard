<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCombined1521838117LocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('locations')) {
            Schema::create('locations', function (Blueprint $table) {
                $table->increments('id');
                $table->string('clinic_website_link')->nullable();
                $table->integer('clinic_location_id')->nullable()->unsigned();
                $table->string('nickname');
                $table->string('address');
                $table->string('address_2')->nullable();
                $table->string('city');
                $table->string('state');
                $table->string('location_email')->nullable();
                $table->string('phone')->nullable();
                $table->string('phone2')->nullable();
                $table->string('storefront')->nullable();
                $table->string('google_map_link')->nullable();

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
        Schema::dropIfExists('locations');
    }
}
