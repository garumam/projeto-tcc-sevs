<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->float('largura');
            $table->float('altura');
            $table->integer('qtd');
            $table->string('localizacao');
            $table->float('valor_mao_obra');
            $table->integer('m_produto_id')->unsigned();
            $table->foreign('m_produto_id')->references('id')->on('m_products');
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
        Schema::dropIfExists('products');
    }
}
