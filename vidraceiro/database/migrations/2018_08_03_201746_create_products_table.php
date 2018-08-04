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
        });

        Schema::create('product_aluminum', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produto_id')->unsigned();
            $table->integer('aluminio_id')->unsigned();
            $table->foreign('produto_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('aluminio_id')->references('id')->on('aluminums')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('product_component', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produto_id')->unsigned();
            $table->integer('componente_id')->unsigned();
            $table->foreign('produto_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('componente_id')->references('id')->on('components')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('product_glass', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produto_id')->unsigned();
            $table->integer('vidro_id')->unsigned();
            $table->foreign('produto_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('vidro_id')->references('id')->on('glasses')->onDelete('cascade');
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
        Schema::dropIfExists('product_aluminum');
        Schema::dropIfExists('product_component');
        Schema::dropIfExists('product_glass');
    }
}
