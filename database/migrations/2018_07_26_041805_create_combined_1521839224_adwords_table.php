<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCombined1521839224AdwordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('adwords')) {
            Schema::create('adwords', function (Blueprint $table) {
                $table->increments('id');
                $table->string('client_customer_id')->nullable();
                $table->string('user_agent')->nullable();
                $table->string('client_id')->nullable();
                $table->string('client_secret')->nullable();
                $table->string('refresh_token')->nullable();
                $table->string('authorization_uri')->nullable();
                $table->string('redirect_uri')->nullable();
                $table->string('token_credential_uri')->nullable();
                $table->string('scope')->nullable();

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
        Schema::dropIfExists('adwords');
    }
}
