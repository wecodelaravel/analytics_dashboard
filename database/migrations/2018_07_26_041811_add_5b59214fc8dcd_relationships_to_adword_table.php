<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Add5b59214fc8dcdRelationshipsToAdwordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adwords', function (Blueprint $table) {
            if (!Schema::hasColumn('adwords', 'company_id')) {
                $table->integer('company_id')->unsigned()->nullable();
                $table->foreign('company_id', '135072_5ab96ca977467')->references('id')->on('contact_companies')->onDelete('cascade');
            }
            if (!Schema::hasColumn('adwords', 'website_id')) {
                $table->integer('website_id')->unsigned()->nullable();
                $table->foreign('website_id', '135072_5ab96ca9883bc')->references('id')->on('websites')->onDelete('cascade');
            }
            if (!Schema::hasColumn('adwords', 'clinic_id')) {
                $table->integer('clinic_id')->unsigned()->nullable();
                $table->foreign('clinic_id', '135072_5ab96ca997239')->references('id')->on('clinics')->onDelete('cascade');
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
        Schema::table('adwords', function (Blueprint $table) {
            if (Schema::hasColumn('adwords', 'company_id')) {
                $table->dropForeign('135072_5ab96ca977467');
                $table->dropIndex('135072_5ab96ca977467');
                $table->dropColumn('company_id');
            }
            if (Schema::hasColumn('adwords', 'website_id')) {
                $table->dropForeign('135072_5ab96ca9883bc');
                $table->dropIndex('135072_5ab96ca9883bc');
                $table->dropColumn('website_id');
            }
            if (Schema::hasColumn('adwords', 'clinic_id')) {
                $table->dropForeign('135072_5ab96ca997239');
                $table->dropIndex('135072_5ab96ca997239');
                $table->dropColumn('clinic_id');
            }
        });
    }
}
