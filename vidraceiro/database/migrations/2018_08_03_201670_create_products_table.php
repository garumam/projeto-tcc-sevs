<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->double('largura')->nullable();
            $table->double('altura')->nullable();
            $table->integer('qtd');
            $table->string('localizacao')->nullable();
            $table->double('valor_mao_obra')->nullable();
            $table->integer('m_produto_id')->unsigned();
            $table->integer('budget_id')->unsigned();
            $table->foreign('m_produto_id')->references('id')->on('m_products')->onDelete('cascade');
            $table->foreign('budget_id')->references('id')->on('budgets')->onDelete('cascade');
            $table->timestamps();
        });
        /*
        Schema::create('product_aluminum', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produto_id')->unsigned();
            $table->integer('aluminio_id')->unsigned();
            $table->foreign('produto_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('aluminio_id')->references('id')->on('aluminums')->onDelete('cascade');

        });

        Schema::create('product_component', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produto_id')->unsigned();
            $table->integer('componente_id')->unsigned();
            $table->foreign('produto_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('componente_id')->references('id')->on('components')->onDelete('cascade');
        });

        Schema::create('product_glass', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produto_id')->unsigned();
            $table->integer('vidro_id')->unsigned();
            $table->foreign('produto_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('vidro_id')->references('id')->on('glasses')->onDelete('cascade');
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        /*Schema::dropIfExists('product_aluminum');
        Schema::dropIfExists('product_component');
        Schema::dropIfExists('product_glass');*/
    }
}
