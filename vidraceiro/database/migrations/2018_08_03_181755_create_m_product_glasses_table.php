<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMProductGlassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_product_glasses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('m_produto_id')->unsigned();
            $table->integer('vidro_id')->unsigned();
            $table->foreign('m_produto_id')->references('id')->on('m_products')->onDelete('cascade');
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
        Schema::dropIfExists('m_product_glasses');
    }
}
