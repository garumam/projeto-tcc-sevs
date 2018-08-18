<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('glasses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('cor')->nullable();
            $table->string('tipo')->nullable();
            $table->integer('espessura');
            $table->float('preco')->nullable();
            $table->integer('is_modelo');
            $table->integer('categoria_vidro_id')->unsigned();
            $table->integer('product_id')->nullable()->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('categoria_vidro_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('m_product_glass', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('m_produto_id')->unsigned();
            $table->integer('vidro_id')->unsigned();
            $table->foreign('m_produto_id')->references('id')->on('m_products')->onDelete('cascade');
            $table->foreign('vidro_id')->references('id')->on('glasses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_product_glass');
        Schema::dropIfExists('glasses');
    }
}
