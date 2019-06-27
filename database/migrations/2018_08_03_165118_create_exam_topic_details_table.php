<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExamTopicDetailsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_topic_details', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('result')->comment('选项序号');
            $table->integer('correct')->nullable()->default(0)->comment('1正确0错误');

            $table->integer('exam_id')->unsigned();
            $table->foreign('exam_id')->references('id')->on('exam_logs');

            $table->integer('topic_id')->unsigned();
            $table->foreign('topic_id')->references('id')->on('topics');

            $table->index(['id', 'created_at']);
            $table->index('exam_id');
            $table->index('topic_id');

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
        Schema::dropIfExists('exam_topic_details');
    }
}
