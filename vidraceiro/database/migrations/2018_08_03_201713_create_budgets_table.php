<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('data');
            $table->string('telefone');
            $table->integer('cep');
            $table->integer('numero_endereco');
            $table->string('rua');
            $table->string('bairro');
            $table->string('uf');
            $table->string('cidade');
            $table->string('complemento');
            $table->float('total');
            $table->float('margem_lucro');
            $table->timestamps();
        });

        Schema::create('budget_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orcamento_id')->unsigned();
            $table->integer('produto_id')->unsigned();
            $table->foreign('orcamento_id')->references('id')->on('budgets')->onDelete('cascade');
            $table->foreign('produto_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('budgets');
        Schema::dropIfExists('budget_product');
    }
}
