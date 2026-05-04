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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contrato_id')->constrained('contratos')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users'); // cajero que cobró
            $table->date('fecha_pago');
            $table->date('periodo_desde');
            $table->date('periodo_hasta');
            $table->decimal('importe', 8, 2);
            $table->decimal('descuento', 8, 2)->default(0);
            $table->decimal('total', 8, 2);
            $table->enum('tipo_pago', ['efectivo', 'transferencia', 'tarjeta'])->default('efectivo');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
