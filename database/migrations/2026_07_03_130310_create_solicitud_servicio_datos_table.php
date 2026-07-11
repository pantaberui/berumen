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
        Schema::create('solicitud_servicio_datos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('solicitud_servicio_id')
                ->constrained('solicitud_servicios')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('campo', 100);
            $table->string('etiqueta', 150)->nullable();
            $table->text('valor')->nullable();

            $table->string('tipo_campo', 50)->default('text');
            // text, number, email, tel, date, textarea, file, select

            $table->boolean('requerido')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_servicio_datos');
    }
};
