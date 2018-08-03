<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderServiceBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_service_budgets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ordem_id')->unsigned();
            $table->integer('orcamento_id')->unsigned();
            $table->foreign('ordem_id')->references('id')->on('order_services')->onDelete('cascade');
            $table->foreign('orcamento_id')->references('id')->on('budgets')->onDelete('cascade');
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
        Schema::dropIfExists('order_service_budgets');
    }
}
