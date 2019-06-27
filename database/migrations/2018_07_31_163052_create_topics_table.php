<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTopicsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type',['文本','音频','视频','图片'])->nullable()->default('文本')->comment('题目类型');
            $table->longtext('name')->nullable()->comment('题目名称');
            $table->longtext('attach_url')->nullable()->comment('附加地址');
            $table->integer('sec_sort')->comment('章节序号');
            $table->integer('num_sort')->comment('题目序号');

            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')->on('job_subjects');

            $table->index(['id', 'created_at']);
            $table->index('sec_sort');
            $table->index('num_sort');
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
        Schema::dropIfExists('topics');
    }
}
