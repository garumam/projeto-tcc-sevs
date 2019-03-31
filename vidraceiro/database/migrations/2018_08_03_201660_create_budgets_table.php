<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('data')->nullable();
            $table->string('status');
            $table->double('total')->nullable();
            $table->double('margem_lucro')->nullable();
            $table->integer('endereco_id')->unsigned();
            $table->integer('ordem_id')->nullable()->unsigned();
            $table->integer('cliente_id')->nullable()->unsigned();
            $table->integer('usuario_id')->nullable()->unsigned();
            $table->integer('contato_id')->unsigned();
            $table->foreign('contato_id')->references('id')->on('contacts');
            $table->foreign('endereco_id')->references('id')->on('locations');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('ordem_id')->references('id')->on('orders');
            $table->foreign('cliente_id')->references('id')->on('clients')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
        /*
        Schema::create('budget_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orcamento_id')->unsigned();
            $table->integer('produto_id')->unsigned();
            $table->foreign('orcamento_id')->references('id')->on('budgets')->onDelete('cascade');
            $table->foreign('produto_id')->references('id')->on('products')->onDelete('cascade');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budgets');
        //Schema::dropIfExists('budget_product');
    }
}
