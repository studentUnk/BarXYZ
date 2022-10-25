<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('usuario_cajero')->nullable();
            $table->bigInteger('usuario_mesero')->nullable();
            $table->bigInteger('codigo_mesa')->nullable();
            $table->bigInteger('codigo_sede')->nullable();
            $table->string('activo',10)->nullable();
            $table->double('valor_venta')->nullable();
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_pago')->nullable();
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
        Schema::dropIfExists('pedidos');
    }
};
