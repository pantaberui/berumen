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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes');
            $table->string('cliente_nombre')->default('PÚBLICO EN GENERAL');
            $table->decimal('subtotal', 8, 2)->default(0);
            $table->decimal('descuento_total', 8, 2)->default(0);
            $table->decimal('total', 8, 2)->default(0);
            $table->enum('tipo_pago', ['efectivo', 'transferencia', 'tarjeta'])->default('efectivo');
            $table->enum('estatus', ['completada', 'cancelada'])->default('completada');
            $table->timestamp('fecha_hora_venta')->nullable();
            $table->timestamp('fecha_hora_cancelacion')->nullable();
            $table->foreignId('cancelado_por')->nullable()->constrained('users');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
