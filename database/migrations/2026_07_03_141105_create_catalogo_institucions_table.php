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
        Schema::create('catalogo_instituciones', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();

            $table->string('logo')->nullable();
            $table->string('icono')->nullable();

            $table->string('color_principal')->nullable();
            $table->string('color_secundario')->nullable();

            $table->integer('orden')->default(0);
            $table->boolean('activo')->default(true);
            $table->boolean('mostrar_en_portada')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogo_instituciones');
    }
};
