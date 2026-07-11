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
        Schema::create('catalogo_servicio_modalidades', function (Blueprint $table) {
            $table->id();

            $table->foreignId('catalogo_servicio_id')
                ->constrained('catalogo_servicios')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('nombre');
            $table->string('slug');
            $table->text('descripcion')->nullable();

            $table->decimal('precio', 10, 2)->nullable();
            $table->string('tipo_precio', 50)->default('fijo');

            $table->string('tiempo_estimado')->nullable();
            $table->boolean('activo')->default(true);
            $table->integer('orden')->default(0);

            $table->timestamps();

            $table->unique(['catalogo_servicio_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
   public function down(): void
    {
        Schema::dropIfExists('catalogo_servicio_modalidades');
    }
};
