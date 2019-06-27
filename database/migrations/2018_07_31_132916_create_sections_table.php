<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSectionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('章节名称');
            $table->integer('sort')->comment('章节序数');

            $table->integer('subject_id')->unsigned();
            $table->foreign('subject_id')->references('id')->on('job_subjects');

            $table->index(['id', 'created_at']);
            $table->index('sort');
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
        Schema::dropIfExists('sections');
    }
}
