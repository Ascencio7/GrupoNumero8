<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('pedidos', function (Blueprint $table) {
        $table->id('Id_Pedido');
        $table->dateTime('FechaPedido');
        $table->dateTime('FechaEntrega');
        $table->string('Observaciones', 150)->nullable();
        $table->unsignedBigInteger('Id_Cliente');
        $table->timestamps();

    $table->foreign('Id_Cliente')->references('Id_Cliente')->on('clientes');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
