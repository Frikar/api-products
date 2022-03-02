<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tabla para los productos
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('descripcion');
            $table->float('precio');
            $table->string('filename')->nullable();
            $table->string('path')->nullable();
            $table->integer('cantidad');
            $table->timestamps();
        });
        // Tabla para los modelos
        Schema::create('modelos_productos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('producto_id');
            $table->string('nombre_modelo');
            $table->string('descripcion_modelo');
            $table->timestamps();
            $table->foreign('producto_id')
                ->references('id')
                ->on('productos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
        Schema::dropIfExists('modelos_productos');
    }
}
