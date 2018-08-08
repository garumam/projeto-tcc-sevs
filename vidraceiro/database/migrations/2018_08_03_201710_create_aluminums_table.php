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
            $table->float('medida')->nullable();
            $table->integer('qtd');
            $table->float('peso')->nullable();
            $table->float('preco')->nullable();
            $table->string('tipo_medida');
            $table->integer('is_modelo');
            $table->integer('categoria_aluminio_id')->unsigned();
            $table->foreign('categoria_aluminio_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('aluminums');
    }
}
