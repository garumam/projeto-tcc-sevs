<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMProductAluminiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_product_aluminios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('m_produto_id')->unsigned();
            $table->integer('aluminio_id')->unsigned();
            $table->foreign('m_produto_id')->references('id')->on('m_products')->onDelete('cascade');
            $table->foreign('aluminio_id')->references('id')->on('aluminios')->onDelete('cascade');
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
        Schema::dropIfExists('m_product_aluminios');
    }
}
