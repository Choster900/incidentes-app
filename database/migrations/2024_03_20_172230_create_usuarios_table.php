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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('name',60); //username
            $table->string('nombres',60);
            $table->string('apellidos',60);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // Referencia a la tabla roles
            $table->foreignId('rol_id')->nullable()->constrained('roles');
            // Referencia a la tabla departamentos
            $table->foreignId('departamento_id')->nullable()->constrained('departamentos');

            $table->string("estado",1)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
