<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobPackagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('job_name')->nullable()->comment('职位名称');

            $table->integer('job_id')->unsigned();
            $table->foreign('job_id')->references('id')->on('jobs');

            $table->integer('month')->comment('月数');
            $table->float('price')->comment('价格');

            $table->index(['id', 'created_at']);
            $table->index('job_id');

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
        Schema::dropIfExists('job_packages');
    }
}
