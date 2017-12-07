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
            $table->string('access_gisn', 50)->default('')->comment('权限功能');
            $table->string('access_permission', 50)->default('')->comment('权限标识');
            
            $table->integer('role_id')->default(0)->comment('角色ID');
            $table->softDeletes();
            $table->timestamps();
            $table->index('role_id');
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
