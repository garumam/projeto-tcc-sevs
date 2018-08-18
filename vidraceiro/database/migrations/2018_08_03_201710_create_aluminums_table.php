<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAluminumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aluminums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('perfil');
            $table->string('descricao')->nullable();
            $table->double('medida')->nullable();
            $table->integer('qtd');
            $table->double('peso')->nullable();
            $table->double('preco')->nullable();
            $table->string('tipo_medida');
            $table->integer('is_modelo');
            $table->integer('categoria_aluminio_id')->unsigned();
            $table->integer('product_id')->nullable()->unsigned();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('categoria_aluminio_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('m_product_aluminum', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('m_produto_id')->unsigned();
            $table->integer('aluminio_id')->unsigned();
            $table->foreign('m_produto_id')->references('id')->on('m_products')->onDelete('cascade');
            $table->foreign('aluminio_id')->references('id')->on('aluminums')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_product_aluminum');
        Schema::dropIfExists('aluminums');
    }
}
