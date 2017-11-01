<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemManagerRoleAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_manager_role_access', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->default(0)->comment('½ÇÉ«ID');
            $table->integer('access_id')->default(0)->coment('È¨ÏÞID');
            $table->index(['role_id', 'access_id']);
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
        Schema::dropIfExists('system_manager_role_access');
    }
}
