<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('solicitud_servicio_pagos', function (Blueprint $table) {
            $table->foreignId('catalogo_cuenta_bancaria_id')
                ->nullable()
                ->after('solicitud_servicio_id')
                ->constrained('catalogo_cuentas_bancarias')
                ->nullOnDelete();

            /*
             * Snapshot de la cuenta utilizada.
             * Se conserva aunque después cambie el catálogo.
             */
            $table->string('banco')->nullable()->after('estatus');
            $table->string('titular')->nullable()->after('banco');
            $table->string('numero_cuenta')->nullable()->after('titular');
            $table->string('clabe_interbancaria', 18)
                ->nullable()
                ->after('numero_cuenta');

            $table->string('codigo_autorizacion')
                ->nullable()
                ->after('referencia_reportada');

            $table->timestamp('fecha_subida')
                ->nullable()
                ->after('codigo_autorizacion');
        });

        /*
         * Permitir crear el registro del pago antes de que exista
         * un comprobante.
         */
        DB::statement(
            'ALTER TABLE solicitud_servicio_pagos
             MODIFY ruta_archivo VARCHAR(255) NULL'
        );

        DB::statement(
            'ALTER TABLE solicitud_servicio_pagos
             MODIFY nombre_original_archivo VARCHAR(255) NULL'
        );

        /*
         * Ampliamos los estados sin perder los registros existentes.
         */
        DB::statement("
            ALTER TABLE solicitud_servicio_pagos
            MODIFY estatus ENUM(
                'pendiente',
                'esperando_comprobante',
                'comprobante_recibido',
                'en_revision',
                'validado',
                'rechazado',
                'cancelado'
            ) NOT NULL DEFAULT 'pendiente'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE solicitud_servicio_pagos
            MODIFY estatus ENUM(
                'pendiente',
                'validado',
                'rechazado'
            ) NOT NULL DEFAULT 'pendiente'
        ");

        Schema::table('solicitud_servicio_pagos', function (Blueprint $table) {
            $table->dropForeign(
                ['catalogo_cuenta_bancaria_id']
            );

            $table->dropColumn([
                'catalogo_cuenta_bancaria_id',
                'banco',
                'titular',
                'numero_cuenta',
                'clabe_interbancaria',
                'codigo_autorizacion',
                'fecha_subida',
            ]);
        });

        /*
         * No volvemos obligatorios los archivos en down(),
         * porque podrían existir pagos sin comprobante.
         */
    }
};
