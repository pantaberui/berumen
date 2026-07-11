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
        Schema::table('catalogo_servicios', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('nombre');

            $table->string('titulo_publico')->nullable()->after('slug');
            $table->text('descripcion_corta')->nullable()->after('descripcion');

            $table->string('logo')->nullable()->after('color');
            $table->string('color_principal')->nullable()->after('logo');
            $table->string('color_secundario')->nullable()->after('color_principal');

            $table->string('tiempo_estimado')->nullable()->after('color_secundario');

            $table->boolean('es_documento_oficial')->default(false)->after('tiempo_estimado');
            $table->boolean('entrega_digital')->default(true)->after('es_documento_oficial');
            $table->boolean('mostrar_en_portada')->default(false)->after('entrega_digital');
            $table->boolean('mostrar_precio')->default(true)->after('mostrar_en_portada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalogo_servicios', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'titulo_publico',
                'descripcion_corta',
                'logo',
                'color_principal',
                'color_secundario',
                'tiempo_estimado',
                'es_documento_oficial',
                'entrega_digital',
                'mostrar_en_portada',
                'mostrar_precio',
            ]);
        });
    }
};
