<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTopicMistakesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_mistakes', function (Blueprint $table) {
            $table->increments('id');


            $table->string('question_type')->comment('问题类型');
            $table->string('content')->comment('详细描述');
            $table->string('question_img')->nullable()->comment('意见图片描述');
            $table->string('commit')->nullable()->comment('联系方式');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('topic_id')->unsigned();
            $table->foreign('topic_id')->references('id')->on('topics');
            
            $table->timestamps();
            $table->softDeletes();
            $table->index(['id', 'created_at']);
            $table->index('user_id');
            $table->index('topic_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('topic_mistakes');
    }
}
