<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('catalogo_servicio_campos');
    }

    public function down(): void
    {
        Schema::create('catalogo_servicio_campos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('catalogo_servicio_id')
                ->constrained('catalogo_servicios')
                ->cascadeOnDelete();

            $table->foreignId('catalogo_campo_id')
                ->constrained('catalogo_campos')
                ->cascadeOnDelete();

            $table->boolean('requerido')->default(false);
            $table->unsignedInteger('orden')->default(0);
            $table->boolean('activo')->default(true);

            $table->timestamps();

            $table->unique([
                'catalogo_servicio_id',
                'catalogo_campo_id',
            ], 'catalogo_servicio_campo_unique');
        });
    }
};