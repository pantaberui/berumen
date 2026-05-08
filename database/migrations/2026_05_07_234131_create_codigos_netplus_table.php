<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('codigos_netplus', function (Blueprint $table) {
        $table->id();
        $table->string('codigo', 20)->unique();
        $table->string('tiempo', 20);
        $table->enum('estatus', ['disponible', 'vendido', 'cancelado'])->default('disponible');
        $table->decimal('importe', 8, 2)->nullable();
        $table->string('tipo_ficha', 50)->nullable();
        $table->timestamp('fecha_alta')->nullable();
        $table->timestamp('fecha_venta')->nullable();
        $table->foreignId('user_id')->nullable()->constrained('users');
        $table->foreignId('cancelado_por')->nullable()->constrained('users');
        $table->timestamp('fecha_cancelacion')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('codigos_netplus');
}
};
