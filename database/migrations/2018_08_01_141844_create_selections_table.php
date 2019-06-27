<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSelectionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selections', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('sort')->comment('选项序号');
            $table->enum('type',['文本','音频','视频','图片'])->nullable()->default('文本')->comment('选项类型');
            $table->longtext('attach_url')->nullable()->comment('附加地址');
            $table->longtext('name')->nullable()->comment('选项描述');

            $table->integer('topic_id')->unsigned();
            $table->foreign('topic_id')->references('id')->on('topics');
            
            $table->integer('is_result')->nullable()->default(0)->comment('0不是答案 1是答案');
            $table->string('letter')->nullable()->comment('对应字母符号');

            $table->index(['id', 'created_at']);
            $table->index('sort');
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
        Schema::dropIfExists('selections');
    }
}
