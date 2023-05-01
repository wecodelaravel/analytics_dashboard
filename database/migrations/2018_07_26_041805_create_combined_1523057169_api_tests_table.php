<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCombined1523057169ApiTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('api_tests')) {
            Schema::create('api_tests', function (Blueprint $table) {
                $table->increments('id');
                $table->string('submitted')->nullable();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('subject')->nullable();
                $table->string('message')->nullable();
                $table->string('submitted_user_city')->nullable();
                $table->string('submitted_user_state')->nullable();
                $table->string('searched_for')->nullable();
                $table->string('country')->nullable();
                $table->string('latitude')->nullable();
                $table->string('longitude')->nullable();

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
        Schema::dropIfExists('api_tests');
    }
}
