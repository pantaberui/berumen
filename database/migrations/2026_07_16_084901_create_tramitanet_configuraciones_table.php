<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tramitanet_configuraciones', function (Blueprint $table) {
            $table->id();

            $table->string('clave')->unique();
            $table->text('valor')->nullable();
            $table->string('tipo')->default('texto');
            $table->string('grupo')->default('general');
            $table->string('descripcion')->nullable();
            $table->boolean('editable')->default(true);

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tramitanet_configuraciones');
    }
};
