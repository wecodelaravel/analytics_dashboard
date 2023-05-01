<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Create5b592150d0ddfTaskTaskTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('task_task_tag')) {
            Schema::create('task_task_tag', function (Blueprint $table) {
                $table->integer('task_id')->unsigned()->nullable();
                $table->foreign('task_id', 'fk_p_136426_136425_taskta_5b592150d0fef')->references('id')->on('tasks')->onDelete('cascade');
                $table->integer('task_tag_id')->unsigned()->nullable();
                $table->foreign('task_tag_id', 'fk_p_136425_136426_task_t_5b592150d111c')->references('id')->on('task_tags')->onDelete('cascade');
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
        Schema::dropIfExists('task_task_tag');
    }
}
