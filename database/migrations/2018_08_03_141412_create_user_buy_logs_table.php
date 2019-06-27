<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserBuyLogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_buy_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->string('number')->nullable()->comment('订单编号');
            $table->enum('pay_status',['未支付','已支付','已完成','已取消'])->nullable()->default('未支付')->comment('支付状态');
            $table->float('price')->comment('订单金额');
            $table->string('package_name')->nullable()->comment('套餐名称');
            $table->integer('package_month')->comment('套餐有效期(月数)');
            
            $table->integer('package_id')->unsigned();
            $table->foreign('package_id')->references('id')->on('job_packages');
        
            $table->integer('job_id')->unsigned();
            $table->foreign('job_id')->references('id')->on('jobs');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->index(['id', 'created_at']);
            $table->index('package_id');
            $table->index('user_id');
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
        Schema::dropIfExists('user_buy_logs');
    }
}
