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
        Schema::create('costos_actas_entidad', function (Blueprint $table) {
            $table->id();

            $table->string('codigo_curp', 2)->unique();
            $table->string('entidad', 100);
            $table->decimal('costo', 10, 2)->default(0);

            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costos_actas_entidad');
    }
};
