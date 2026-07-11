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
        Schema::table('catalogo_campos', function (Blueprint $table) {
            $table->string('grupo_expediente', 50)
                ->default('datos')
                ->after('tipo_campo');
        });
    }

    public function down(): void
    {
        Schema::table('catalogo_campos', function (Blueprint $table) {
            $table->dropColumn('grupo_expediente');
        });
    }
};
