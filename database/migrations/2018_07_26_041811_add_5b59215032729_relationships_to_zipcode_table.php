<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Add5b59215032729RelationshipsToZipcodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zipcodes', function (Blueprint $table) {
            if (!Schema::hasColumn('zipcodes', 'clinic_id')) {
                $table->integer('clinic_id')->unsigned()->nullable();
                $table->foreign('clinic_id', '136409_5ab9732708026')->references('id')->on('clinics')->onDelete('cascade');
            }
            if (!Schema::hasColumn('zipcodes', 'location_id')) {
                $table->integer('location_id')->unsigned()->nullable();
                $table->foreign('location_id', '136409_5ab973271ea8d')->references('id')->on('locations')->onDelete('cascade');
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
        Schema::table('zipcodes', function (Blueprint $table) {
            if (Schema::hasColumn('zipcodes', 'clinic_id')) {
                $table->dropForeign('136409_5ab9732708026');
                $table->dropIndex('136409_5ab9732708026');
                $table->dropColumn('clinic_id');
            }
            if (Schema::hasColumn('zipcodes', 'location_id')) {
                $table->dropForeign('136409_5ab973271ea8d');
                $table->dropIndex('136409_5ab973271ea8d');
                $table->dropColumn('location_id');
            }
        });
    }
}
