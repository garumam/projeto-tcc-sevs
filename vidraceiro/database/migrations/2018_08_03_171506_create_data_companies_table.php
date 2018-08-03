<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('endereco');
            $table->string('cidade');
            $table->string('bairro');
            $table->string('uf');
            $table->string('email');
            $table->string('telefone');
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
        Schema::dropIfExists('data_companies');
    }
}
