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
        Schema::table('solicitud_servicio_datos', function (Blueprint $table) {
            if (!Schema::hasColumn('solicitud_servicio_datos', 'catalogo_campo_id')) {
                $table->unsignedBigInteger('catalogo_campo_id')->nullable()->after('solicitud_servicio_id');
            }

            if (!Schema::hasColumn('solicitud_servicio_datos', 'es_archivo')) {
                $table->boolean('es_archivo')->default(false)->after('valor');
            }

            if (!Schema::hasColumn('solicitud_servicio_datos', 'ruta_archivo')) {
                $table->string('ruta_archivo')->nullable()->after('es_archivo');
            }

            if (!Schema::hasColumn('solicitud_servicio_datos', 'nombre_original_archivo')) {
                $table->string('nombre_original_archivo')->nullable()->after('ruta_archivo');
            }

            if (!Schema::hasColumn('solicitud_servicio_datos', 'mime_type')) {
                $table->string('mime_type')->nullable()->after('nombre_original_archivo');
            }

            if (!Schema::hasColumn('solicitud_servicio_datos', 'tamano_archivo')) {
                $table->unsignedBigInteger('tamano_archivo')->nullable()->after('mime_type');
            }
        });

        Schema::table('solicitud_servicio_datos', function (Blueprint $table) {
            $table->foreign('catalogo_campo_id', 'sol_dato_campo_fk')
                ->references('id')
                ->on('catalogo_campos')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitud_servicio_datos', function (Blueprint $table) {
            $table->dropForeign('sol_dato_campo_fk');

            $table->dropColumn([
                'catalogo_campo_id',
                'es_archivo',
                'ruta_archivo',
                'nombre_original_archivo',
                'mime_type',
                'tamano_archivo',
            ]);
        });
    }
};
