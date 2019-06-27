<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateJobsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            if(!Schema::hasColumn('jobs', 'is_show')){
                $table->integer('is_show')->nullable()->default(1)->comment('前端显示1不显示0');
            }
            if(!Schema::hasColumn('jobs', 'is_delete')){
                $table->integer('is_delete')->nullable()->default(0)->comment('是否被删除1被删除0未被删除');
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
        
    }
}
