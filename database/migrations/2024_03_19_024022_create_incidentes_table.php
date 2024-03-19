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
        Schema::create('incidentes', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 600);
            // Referencia a la tabla usuarios
            $table->foreignId('usuario_id')->constrained('usuarios');
            // Referencia a la tabla usuarios
            $table->foreignId('tecnico_id')->nullable()->constrained('usuarios');
            $table->integer('estado');
            $table->date('fecha_registro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidentes');
    }
};
