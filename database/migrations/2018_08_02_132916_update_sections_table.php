<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateSectionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sections', function (Blueprint $table) {
            if(!Schema::hasColumn('sections', 'get_num')){
                $table->integer('get_num')->nullalbe()->default(10)->comment('前端取题数目');
            }

            if(!Schema::hasColumn('sections', 'is_delete')){
                $table->integer('is_delete')->nullable()->default(0)->comment('是否被删除0没被删除1被删除');
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
