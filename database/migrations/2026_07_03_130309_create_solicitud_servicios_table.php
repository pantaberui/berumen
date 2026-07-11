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
        Schema::create('solicitud_servicios', function (Blueprint $table) {
            $table->id();

            $table->string('folio', 20)->unique();
            $table->string('referencia_pago', 7)->unique();

            $table->foreignId('catalogo_servicio_id')
                ->constrained('catalogo_servicios')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('estatus', 50)->default('solicitado');

            $table->string('curp', 18)->nullable();
            $table->string('entidad_curp_codigo', 2)->nullable();
            $table->string('entidad_curp_nombre', 100)->nullable();

            $table->string('nombre_solicitante')->nullable();
            $table->string('correo')->nullable();
            $table->string('telefono_whatsapp', 20)->nullable();

            $table->string('medio_entrega', 30)->default('whatsapp');
            // whatsapp, correo, ambos

            $table->decimal('monto_base', 10, 2)->default(0);
            $table->decimal('comision', 10, 2)->default(0);
            $table->decimal('total_pagar', 10, 2)->default(0);

            $table->string('metodo_pago', 30)->nullable();
            // transferencia, deposito

            $table->string('banco_pago')->nullable();
            $table->string('concepto_pago')->nullable();

            $table->text('observaciones_cliente')->nullable();
            $table->text('observaciones_admin')->nullable();

            $table->string('archivo_pdf_final')->nullable();

            $table->timestamp('fecha_pago_confirmado')->nullable();
            $table->timestamp('fecha_enviado')->nullable();

            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_servicios');
    }
};
