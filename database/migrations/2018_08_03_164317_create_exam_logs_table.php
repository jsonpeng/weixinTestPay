<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExamLogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->string('subject_name')->nullable()->comment('科目名称');
            $table->integer('result')->comment('答题结果');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')->on('job_subjects');

            $table->index(['id', 'created_at']);
            $table->index('user_id');
            $table->index('subject_id');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_logs');
    }
}
