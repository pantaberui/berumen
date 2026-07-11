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
        Schema::table('catalogo_servicio_campos', function (Blueprint $table) {
            $table->json('opciones_personalizadas')->nullable()->after('activo');

            $table->dropColumn([
                'campo',
                'etiqueta',
                'tipo_campo',
                'placeholder',
                'ayuda',
                'titulo_ayuda',
                'imagen_ayuda',
                'validacion',
                'opciones',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalogo_servicio_campos', function (Blueprint $table) {
            $table->string('campo', 100)->nullable();
            $table->string('etiqueta', 150)->nullable();
            $table->string('tipo_campo', 50)->default('text');
            $table->string('placeholder')->nullable();
            $table->text('ayuda')->nullable();
            $table->string('titulo_ayuda')->nullable();
            $table->string('imagen_ayuda')->nullable();
            $table->string('validacion')->nullable();
            $table->json('opciones')->nullable();

            $table->dropColumn('opciones_personalizadas');
        });
    }
};
