<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('storages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qtd')->default(0);
            $table->integer('glass_id')->nullable()->unsigned();
            $table->integer('aluminum_id')->nullable()->unsigned();
            $table->integer('component_id')->nullable()->unsigned();
            $table->foreign('glass_id')->references('id')->on('glasses')->onDelete('cascade');
            $table->foreign('aluminum_id')->references('id')->on('aluminums')->onDelete('cascade');
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('storage_sale', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('venda_id')->unsigned();
            $table->integer('estoque_id')->unsigned();
            $table->integer('qtd_reservada');
            $table->foreign('venda_id')->references('id')->on('sales')->onDelete('cascade');
            $table->foreign('estoque_id')->references('id')->on('storages')->onDelete('cascade');
            $table->timestamps();
        });
        /*Schema::create('storage_glasses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('metro_quadrado')->default(0);
            $table->integer('glass_id')->unsigned();
            $table->foreign('glass_id')->references('id')->on('glasses')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('storage_aluminums', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qtd')->default(0);
            $table->integer('aluminum_id')->unsigned();
            $table->foreign('aluminum_id')->references('id')->on('aluminums')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('storage_components', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qtd')->default(0);
            $table->integer('component_id')->unsigned();
            $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');
            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storages');
        /*Schema::dropIfExists('storage_glasses');
        Schema::dropIfExists('storage_aluminums');
        Schema::dropIfExists('storage_components');*/
    }
}
