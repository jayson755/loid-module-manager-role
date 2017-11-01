<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemManagerAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_manager_access', function (Blueprint $table) {
            $table->increments('access_id')->comment('自增列');
            $table->string('access_gisn', 50)->default('')->comment('权限标识');
            $table->string('access_description')->default('')->comment('权限描述');
            $table->string('access_moudle', 50)->default('')->comment('所属模块');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_manager_access');
    }
}
