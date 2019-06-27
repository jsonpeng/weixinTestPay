<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
              if(!Schema::hasColumn('users', 'show_time')){
                    $table->integer('show_time')->nullable()->default(3)->comment('验证码校检');
              }
              if(!Schema::hasColumn('users', 'key')){
                    $table->string('key')->nullable()->comment('密钥');
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
