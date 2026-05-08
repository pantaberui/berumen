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
        Schema::create('pagos_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_servicio_id')->constrained('tipo_servicios');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('user_id')->constrained('users');
            $table->string('referencia', 100);
            $table->decimal('importe', 8, 2);
            $table->decimal('comision', 8, 2)->default(25);
            $table->decimal('total', 8, 2);
            $table->enum('tipo_pago', ['efectivo', 'transferencia', 'tarjeta'])->default('efectivo');
            $table->enum('estatus', ['pagado', 'cancelado'])->default('pagado');
            $table->timestamp('fecha_hora_registro')->nullable();
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
        Schema::dropIfExists('pagos_servicios');
    }
};
