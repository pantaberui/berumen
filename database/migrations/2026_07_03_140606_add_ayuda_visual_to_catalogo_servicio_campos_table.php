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
        Schema::table('catalogo_servicios', function (Blueprint $table) {

            $table->foreignId('catalogo_institucion_id')
                ->nullable()
                ->after('categoria')
                ->constrained('catalogo_instituciones')
                ->nullOnDelete();

            $table->dropColumn('subcategoria');

        });
    }

    /**
     * Reverse the migrations.
     */
  public function down(): void
    {
        Schema::table('catalogo_servicios', function (Blueprint $table) {

            $table->string('subcategoria')->nullable();

            $table->dropConstrainedForeignId('catalogo_institucion_id');

        });
    }
};
