<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('data_inicial')->nullable();
            $table->double('total')->nullable();
            $table->string('data_final')->nullable();
            $table->string('situacao')->nullable();
            $table->timestamps();
        });

        /*Schema::create('order_budget', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ordem_id')->unsigned();
            $table->integer('orcamento_id')->unsigned();
            $table->foreign('ordem_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('orcamento_id')->references('id')->on('budgets')->onDelete('cascade');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_budget');
    }
}
