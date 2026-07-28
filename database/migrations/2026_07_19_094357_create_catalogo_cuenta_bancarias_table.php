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
        Schema::create('catalogo_cuentas_bancarias', function (Blueprint $table) {
            $table->id();

            // Identificación
            $table->string('alias', 100);
            $table->string('slug')->unique();

            // Banco y titular
            $table->string('banco', 100);
            $table->string('titular', 150);

            // Datos bancarios
            $table->string('numero_cuenta', 30)->nullable();
            $table->string('clabe_interbancaria', 30)->nullable();
            $table->string('numero_tarjeta', 30)->nullable();

            // Información adicional
            $table->string('tipo_cuenta', 50)->nullable();
            $table->string('moneda', 10)->default('MXN');

            // Formas de pago aceptadas
            $table->boolean('acepta_transferencia')->default(true);
            $table->boolean('acepta_deposito')->default(true);

            // Presentación e instrucciones
            $table->string('logo')->nullable();
            $table->text('instrucciones')->nullable();

            // Control
            $table->boolean('es_principal')->default(false);
            $table->boolean('activo')->default(true);
            $table->unsignedInteger('orden')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogo_cuentas_bancarias');
    }
};
