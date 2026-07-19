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
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('catalogo_campo_id')
                ->nullable()
                ->constrained('catalogo_campos')
                ->nullOnDelete();

            $table->boolean('requerido')->default(true);
            $table->integer('orden')->default(0);
            $table->boolean('activo')->default(true);

            $table->json('opciones_personalizadas')->nullable();

            $table->timestamps();
        });
    }
};