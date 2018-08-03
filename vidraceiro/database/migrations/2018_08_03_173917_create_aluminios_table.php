<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAluminiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aluminios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('perfil');
            $table->string('descricao');
            $table->float('medida');
            $table->integer('qtd');
            $table->float('peso');
            $table->float('preco');
            $table->integer('tipo_medida');
            $table->integer('is_modelo');
            $table->integer('categoria_aluminio_id')->unsigned();
            $table->foreign('categoria_aluminio_id')->references('id')->on('categories');
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
        Schema::dropIfExists('aluminios');
    }
}
