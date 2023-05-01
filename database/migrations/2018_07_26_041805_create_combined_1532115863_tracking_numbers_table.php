<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCombined1532115863TrackingNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tracking_numbers')) {
            Schema::create('tracking_numbers', function (Blueprint $table) {
                $table->increments('id');
                $table->string('metrics_id')->nullable();
                $table->string('number')->nullable();
                $table->string('callmetric_filter_id')->nullable();

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
        Schema::dropIfExists('tracking_numbers');
    }
}
