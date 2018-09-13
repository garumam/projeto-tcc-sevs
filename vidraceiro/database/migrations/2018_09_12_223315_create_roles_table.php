<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->timestamps();
        });
        Schema::create('role_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
//            $table->primary(['permission_id','role_id']);
        });
        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
//            $table->primary(['user_id','role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('role_user');
    }
}
