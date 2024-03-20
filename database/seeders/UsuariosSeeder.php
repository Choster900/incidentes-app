<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'nombres' => 'Administrador',
            'apellidos' => 'General',
            'email' => 'admin@example.com',
            'password' => bcrypt('12345678'),
            'estado' => "I"
            // Agrega otros campos de tu tabla 'usuarios' aquí
        ]);
    }
}
