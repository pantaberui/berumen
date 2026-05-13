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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->integer('numero')->unique();
            $table->enum('tipo', ['computadora', 'videojuego']);
            $table->string('descripcion', 100)->nullable();
            $table->enum('estatus', ['disponible', 'en_uso', 'pausado', 'inactivo'])->default('disponible');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
