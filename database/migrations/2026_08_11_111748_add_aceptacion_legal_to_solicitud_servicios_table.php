<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('solicitud_servicios', function (Blueprint $table) {
            $table->timestamp('terminos_aceptados_at')
                ->nullable()
                ->after('fecha_enviado');

            $table->timestamp('privacidad_aceptada_at')
                ->nullable()
                ->after('terminos_aceptados_at');
        });
    }

    public function down(): void
    {
        Schema::table('solicitud_servicios', function (Blueprint $table) {
            $table->dropColumn([
                'terminos_aceptados_at',
                'privacidad_aceptada_at',
            ]);
        });
    }
};
