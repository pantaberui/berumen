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
        Schema::table('solicitud_servicios', function (Blueprint $table) {
            $table->foreignId('catalogo_servicio_modalidad_id')
                ->nullable()
                ->after('catalogo_servicio_id')
                ->constrained('catalogo_servicio_modalidades')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('solicitud_servicios', function (Blueprint $table) {
            $table->dropConstrainedForeignId('catalogo_servicio_modalidad_id');
        });
    }

};
