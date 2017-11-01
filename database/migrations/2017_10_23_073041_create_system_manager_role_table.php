<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemManagerRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_manager_role', function (Blueprint $table) {
            $table->increments('role_id')->comment('自增列');
            $table->string('role_name', 50)->comment('角色名');
            $table->string('role_description')->comment('角色描述');
            $table->string('role_status', 3)->comment('角色状态:on/off');
            $table->integer('role_belong')->comment('数据添加所属人');
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
        Schema::dropIfExists('system_manager_role');
    }
}
