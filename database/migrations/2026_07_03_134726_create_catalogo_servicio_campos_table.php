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
        Schema::create('catalogo_servicio_campos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('catalogo_servicio_id')
                ->constrained('catalogo_servicios')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('campo', 100);
            $table->string('etiqueta', 150);

            $table->string('tipo_campo', 50)->default('text');
            // text, email, tel, number, date, textarea, select, file, curp, rfc, nss

            $table->boolean('requerido')->default(true);

            $table->string('placeholder')->nullable();
            $table->text('ayuda')->nullable();

            $table->string('validacion')->nullable();
            // curp, rfc, email, telefono, nss, nullable, etc.

            $table->json('opciones')->nullable();
            // para combos/select

            $table->integer('orden')->default(0);
            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogo_servicio_campos');
    }
};
