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
        Schema::create('solicitud_servicio_notas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('solicitud_servicio_id')
                ->constrained('solicitud_servicios')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();


            $table->text('nota');

            $table->string('tipo')->default('nota');

            $table->boolean('visible_cliente')->default(false);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitud_servicio_notas');
    }
};
