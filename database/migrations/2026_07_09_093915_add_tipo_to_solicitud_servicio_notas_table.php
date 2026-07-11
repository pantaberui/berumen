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
        Schema::table('solicitud_servicio_notas', function (Blueprint $table) {
            $table->string('tipo')->default('nota')->after('nota');
        });
    }

    public function down(): void
    {
        Schema::table('solicitud_servicio_notas', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
};
