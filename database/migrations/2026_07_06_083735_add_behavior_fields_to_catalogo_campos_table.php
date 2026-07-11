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
            $table->string('transformacion', 30)->nullable()->after('validacion');
            // mayusculas, minusculas, capitalizar

            $table->string('autocomplete')->nullable()->after('transformacion');
            // email, tel, off, name

            $table->string('accept')->nullable()->after('imagen_ayuda');
            // .pdf,.jpg,.jpeg,.png,.cer,.key

            $table->integer('tamano_maximo_mb')->nullable()->after('accept');

            $table->boolean('multiple')->default(false)->after('tamano_maximo_mb');

            $table->string('icono')->nullable()->after('multiple');

            $table->text('ayuda_operador')->nullable()->after('ayuda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catalogo_campos', function (Blueprint $table) {
            $table->dropColumn([
                'transformacion',
                'autocomplete',
                'accept',
                'tamano_maximo_mb',
                'multiple',
                'icono',
                'ayuda_operador',
            ]);
        });
    }
};
