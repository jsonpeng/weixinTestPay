<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateJobSubjectsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_subjects', function (Blueprint $table) {
            if(!Schema::hasColumn('job_subjects', 'time')){
                $table->integer('time')->nullable()->default(0)->comment('科目考试时间');
            }
            if(!Schema::hasColumn('job_subjects', 'is_show')){
                $table->integer('is_show')->nullable()->default(1)->comment('前端显示1不显示0');
            }
            if(!Schema::hasColumn('job_subjects', 'is_delete')){
                $table->integer('is_delete')->nullable()->default(0)->comment('是否被删除1被删除0未被删除');
            }
            if(!Schema::hasColumn('job_subjects', 'sort')){
                $table->integer('sort')->nullable()->default(0)->comment('排序权重');
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
        // Schema::dropIfExists('job_subjects');
    }
}
