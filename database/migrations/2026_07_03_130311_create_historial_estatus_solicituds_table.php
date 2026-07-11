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
        Schema::create('historial_estatus_solicitudes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('solicitud_servicio_id')
                ->constrained('solicitud_servicios')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('estatus_anterior', 50)->nullable();
            $table->string('estatus_nuevo', 50);

            $table->text('observacion')->nullable();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_estatus_solicituds');
    }
};
