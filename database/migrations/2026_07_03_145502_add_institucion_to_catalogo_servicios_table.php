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
            $table->foreignId('catalogo_campo_id')
                ->nullable()
                ->after('solicitud_servicio_id')
                ->constrained('catalogo_campos')
                ->nullOnDelete();

            $table->boolean('es_archivo')->default(false)->after('valor');
            $table->string('ruta_archivo')->nullable()->after('es_archivo');
            $table->string('nombre_original_archivo')->nullable()->after('ruta_archivo');
            $table->string('mime_type')->nullable()->after('nombre_original_archivo');
            $table->unsignedBigInteger('tamano_archivo')->nullable()->after('mime_type');
        });
    }

    public function down(): void
    {
        Schema::table('solicitud_servicio_datos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('catalogo_campo_id');

            $table->dropColumn([
                'es_archivo',
                'ruta_archivo',
                'nombre_original_archivo',
                'mime_type',
                'tamano_archivo',
            ]);
        });
    }

};
