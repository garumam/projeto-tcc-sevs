<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('situacao');
            $table->string('telefone');
            $table->string('celular');
            $table->string('cnpj');
            $table->integer('numero_endereco');
            $table->integer('cep');
            $table->string('rua');
            $table->string('bairro');
            $table->string('email');
            $table->string('cidade');
            $table->string('uf');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
