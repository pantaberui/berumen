<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('catalogo_servicio_campos', function (Blueprint $table) {
            $table->string('titulo_ayuda')
                ->nullable()
                ->after('ayuda');

            $table->string('imagen_ayuda')
                ->nullable()
                ->after('titulo_ayuda');
        });
    }

    public function down(): void
    {
        Schema::table('catalogo_servicio_campos', function (Blueprint $table) {
            $table->dropColumn([
                'titulo_ayuda',
                'imagen_ayuda',
            ]);
        });
    }
};
