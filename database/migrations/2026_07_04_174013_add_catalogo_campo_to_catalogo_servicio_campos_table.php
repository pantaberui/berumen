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
        Schema::table('catalogo_servicio_campos', function (Blueprint $table) {
            $table->foreignId('catalogo_campo_id')
                ->nullable()
                ->after('catalogo_servicio_id')
                ->constrained('catalogo_campos')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalogo_servicio_campos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('catalogo_campo_id');
        });
    }
};
