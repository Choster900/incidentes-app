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
            'id' => 1,
            'name' => 'JDoe',
            'nombres' => 'John',
            'apellidos' => 'Doe',
            'email' => 'jdoe@example.com',
            'password' => bcrypt('12345678'),
            'estado' => "A",
            'rol_id' => 1,
            'departamento_id' => 1
            // Agrega otros campos de tu tabla 'usuarios' aquí
        ]);
    }
}
