<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::create([
            'id' => 1,
            'nombre' => 'Administrador',
            // Agrega otros campos de tu tabla 'usuarios' aquí
        ]);
        Rol::create([
            'id' => 2,
            'nombre' => 'Usuario',
            // Agrega otros campos de tu tabla 'usuarios' aquí
        ]);
        Rol::create([
            'id' => 3,
            'nombre' => 'Tecnico',
            // Agrega otros campos de tu tabla 'usuarios' aquí
        ]);
    }
}
