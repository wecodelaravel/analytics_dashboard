<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Add5b59214dc0346RelationshipsToContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (!Schema::hasColumn('contacts', 'company_id')) {
                $table->integer('company_id')->unsigned()->nullable();
                $table->foreign('company_id', '135003_5ab54697c4a53')->references('id')->on('contact_companies')->onDelete('cascade');
            }
            if (!Schema::hasColumn('contacts', 'clinic_id')) {
                $table->integer('clinic_id')->unsigned()->nullable();
                $table->foreign('clinic_id', '135003_5ab967aebc739')->references('id')->on('clinics')->onDelete('cascade');
            }
            if (!Schema::hasColumn('contacts', 'user_id')) {
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', '135003_5ab54a3b2237b')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('contacts', function (Blueprint $table) {
            if (Schema::hasColumn('contacts', 'company_id')) {
                $table->dropForeign('135003_5ab54697c4a53');
                $table->dropIndex('135003_5ab54697c4a53');
                $table->dropColumn('company_id');
            }
            if (Schema::hasColumn('contacts', 'clinic_id')) {
                $table->dropForeign('135003_5ab967aebc739');
                $table->dropIndex('135003_5ab967aebc739');
                $table->dropColumn('clinic_id');
            }
            if (Schema::hasColumn('contacts', 'user_id')) {
                $table->dropForeign('135003_5ab54a3b2237b');
                $table->dropIndex('135003_5ab54a3b2237b');
                $table->dropColumn('user_id');
            }
        });
    }
}
