<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Add5b59214d7f018RelationshipsToTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('tasks', 'status_id')) {
                $table->integer('status_id')->unsigned()->nullable();
                $table->foreign('status_id', '136426_5ab97d10f1b6a')->references('id')->on('task_statuses')->onDelete('cascade');
            }
            if (!Schema::hasColumn('tasks', 'user_id')) {
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id', '136426_5ab97d1111f1c')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('tasks', function (Blueprint $table) {
            if (Schema::hasColumn('tasks', 'status_id')) {
                $table->dropForeign('136426_5ab97d10f1b6a');
                $table->dropIndex('136426_5ab97d10f1b6a');
                $table->dropColumn('status_id');
            }
            if (Schema::hasColumn('tasks', 'user_id')) {
                $table->dropForeign('136426_5ab97d1111f1c');
                $table->dropIndex('136426_5ab97d1111f1c');
                $table->dropColumn('user_id');
            }
        });
    }
}
