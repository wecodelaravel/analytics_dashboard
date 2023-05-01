<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Add5b59215071a22RelationshipsToTrackingNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracking_numbers', function (Blueprint $table) {
            if (!Schema::hasColumn('tracking_numbers', 'location_id')) {
                $table->integer('location_id')->unsigned()->nullable();
                $table->foreign('location_id', '186806_5b523b981dd76')->references('id')->on('locations')->onDelete('cascade');
            }
            if (!Schema::hasColumn('tracking_numbers', 'company_id')) {
                $table->integer('company_id')->unsigned()->nullable();
                $table->foreign('company_id', '186806_5b523b983f4ea')->references('id')->on('contact_companies')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tracking_numbers', function (Blueprint $table) {
            if (Schema::hasColumn('tracking_numbers', 'location_id')) {
                $table->dropForeign('186806_5b523b981dd76');
                $table->dropIndex('186806_5b523b981dd76');
                $table->dropColumn('location_id');
            }
            if (Schema::hasColumn('tracking_numbers', 'company_id')) {
                $table->dropForeign('186806_5b523b983f4ea');
                $table->dropIndex('186806_5b523b983f4ea');
                $table->dropColumn('company_id');
            }
        });
    }
}
