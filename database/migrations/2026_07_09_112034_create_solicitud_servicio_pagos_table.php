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
        Schema::create('solicitud_servicio_pagos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('solicitud_servicio_id')
                ->constrained('solicitud_servicios')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('estatus', [
                'pendiente',
                'validado',
                'rechazado',
            ])->default('pendiente');

            $table->string('ruta_archivo');
            $table->string('nombre_original_archivo');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('tamano_archivo')->nullable();

            $table->decimal('monto_reportado', 10, 2)->nullable();
            $table->string('referencia_reportada')->nullable();

            $table->text('observacion')->nullable();
            $table->timestamp('fecha_validacion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitud_servicio_pagos');
    }
};
