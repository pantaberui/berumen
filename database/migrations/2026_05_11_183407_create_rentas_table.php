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
        Schema::create('rentas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained('equipos');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamp('hora_inicio');
            $table->integer('segundos_acumulados')->default(0); // Para pausas
            $table->timestamp('hora_pausa')->nullable();
            $table->timestamp('hora_fin')->nullable();
            $table->integer('tiempo_asignado_segundos')->nullable(); // Si se asignó tiempo fijo
            $table->decimal('total_renta', 8, 2)->default(0);
            $table->decimal('total_productos', 8, 2)->default(0);
            $table->decimal('total', 8, 2)->default(0);
            $table->enum('estatus', ['activa', 'pausada', 'cobrada', 'cancelada'])->default('activa');
            $table->timestamp('hora_cobro')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentas');
    }
};
