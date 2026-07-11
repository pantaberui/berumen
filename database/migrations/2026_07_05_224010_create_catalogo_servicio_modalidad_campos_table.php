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
        Schema::create('catalogo_servicio_modalidad_campos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('catalogo_servicio_modalidad_id');
            $table->unsignedBigInteger('catalogo_campo_id');

            $table->boolean('requerido')->default(true);
            $table->integer('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->json('opciones_personalizadas')->nullable();

            $table->timestamps();

            $table->foreign('catalogo_servicio_modalidad_id', 'mod_campo_modalidad_fk')
                ->references('id')
                ->on('catalogo_servicio_modalidades')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('catalogo_campo_id', 'mod_campo_campo_fk')
                ->references('id')
                ->on('catalogo_campos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unique([
                'catalogo_servicio_modalidad_id',
                'catalogo_campo_id'
            ], 'modalidad_campo_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogo_servicio_modalidad_campos');
    }
};
