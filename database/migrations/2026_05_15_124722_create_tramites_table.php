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
        Schema::create('tramites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_tramite_id')->constrained('tipo_tramites');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes');
            $table->string('cliente_nombre')->default('PÚBLICO EN GENERAL');
            $table->integer('cantidad')->default(1);
            $table->decimal('importe', 8, 2);
            $table->decimal('subtotal', 8, 2);
            $table->text('observaciones')->nullable();
            $table->timestamp('fecha_hora_cobro')->nullable();
            $table->enum('estatus', ['cobrado', 'cancelado'])->default('cobrado');
            $table->timestamp('fecha_hora_cancelacion')->nullable();
            $table->foreignId('cancelado_por')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramites');
    }
};
