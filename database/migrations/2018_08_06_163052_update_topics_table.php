<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateTopicsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topics', function (Blueprint $table) {
            if(!Schema::hasColumn('topics', 'value')){
                $table->double('value',15,3)->nullable()->default(0.625)->comment('题目分值');
            }
            if(!Schema::hasColumn('topics', 'is_delete')){
                $table->integer('is_delete')->nullable()->default(0)->comment('是否被删除0没被删除1被删除');
            }
            if(!Schema::hasColumn('topics', 'group')){
                $table->integer('group')->nullable()->default(0)->comment('组');
            }
            if(!Schema::hasColumn('topics', 'group_type')){
                $table->integer('group_type')->nullable()->default(0)->comment('组类型0普通题1首个组题2普通组题');
            }
            if(!Schema::hasColumn('topics', 'topic_type')){
                $table->string('topic_type')->nullable()->default('普通题')->comment('普通题 单句听力题 对话听力题  短文听力题');
            }
            if(!Schema::hasColumn('topics', 'attach_sound_url')){
                $table->string('attach_sound_url')->nullable()->comment('单句/对话/短文的额外音频地址');
            }
            if(!Schema::hasColumn('topics', 'selection_sound_url')){
                $table->string('selection_sound_url')->nullable()->comment('选项音频地址');
            }
            if(!Schema::hasColumn('topics', 'question')){
                $table->longtext('question')->nullable()->comment('问题内容');
            }
            if(!Schema::hasColumn('topics', 'union_type')){
                $table->integer('union_type')->nullable()->default(0)->comment('听力可选类型0普通1题干显示 问题显示（对话和短文有问题，单句只有题干） 选项显示（单句、对话、短文都显示）
2题干隐藏 问题隐藏 选项隐藏（单句的选项隐藏，对话和短文的选项显示）——甲类无限航区
3题干隐藏 问题显示（对话和短文的问题也显示） 选项显示（单句、对话和短文的选项都显示）————丙类沿海航区');
            }
            if(!Schema::hasColumn('topics', 'other_type')){
                $table->integer('other_type')->nullable()->default(0)->comment('0普通 1甲类无限航区  题干隐藏 问题隐藏 选项隐藏（单句的选项隐藏，对话和短文的选项显示）
2丙类沿海航区  题干隐藏 问题显示（对话和短文的问题显示） 选项显示（单句、对话和短文的选项都显示）');
            }
            
            // $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
    }
}
