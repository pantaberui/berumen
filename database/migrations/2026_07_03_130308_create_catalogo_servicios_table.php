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
        Schema::create('catalogo_servicios', function (Blueprint $table) {
            $table->id();

            $table->string('categoria', 50); 
            // tramite, pago_servicio, recarga, pin

            $table->string('subcategoria', 100)->nullable(); 
            // SAT, IMSS, INFONAVIT, Registro Civil, etc.

            $table->string('nombre');

            $table->text('descripcion')->nullable();
            $table->text('requisitos')->nullable();

            $table->string('tipo_precio', 50)->default('fijo');
            // fijo, abierto, combo, por_entidad

            $table->decimal('precio', 10, 2)->nullable();

            $table->boolean('cobra_comision')->default(false);

            $table->json('montos_disponibles')->nullable();
            // para recargas o pines

            $table->string('icono')->nullable();
            $table->string('color')->nullable();

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
        Schema::dropIfExists('catalogo_servicios');
    }
};
