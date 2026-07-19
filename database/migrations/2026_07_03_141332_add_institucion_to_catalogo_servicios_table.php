<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('catalogo_servicios', function (Blueprint $table) {
            $table->foreignId('catalogo_institucion_id')
                ->nullable()
                ->after('categoria')
                ->constrained('catalogo_instituciones')
                ->nullOnDelete();

            $table->dropColumn('subcategoria');
        });
    }

    public function down(): void
    {
        Schema::table('catalogo_servicios', function (Blueprint $table) {
            $table->dropConstrainedForeignId('catalogo_institucion_id');

            $table->string('subcategoria')
                ->nullable()
                ->after('categoria');
        });
    }
};
