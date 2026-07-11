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
        Schema::create('catalogo_campos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->string('slug')->unique();

            $table->string('tipo_campo', 50)->default('text');
            // text, email, tel, number, date, textarea, select, file, curp, rfc, nss

            $table->string('validacion')->nullable();
            $table->string('placeholder')->nullable();
            $table->text('ayuda')->nullable();

            $table->string('titulo_ayuda')->nullable();
            $table->string('imagen_ayuda')->nullable();

            $table->integer('longitud_minima')->nullable();
            $table->integer('longitud_maxima')->nullable();

            $table->json('opciones')->nullable();

            $table->boolean('activo')->default(true);
            $table->integer('orden')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogo_campos');
    }
};
