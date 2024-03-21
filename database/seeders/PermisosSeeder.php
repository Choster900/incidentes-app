<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permiso::create([
            'id' => 1,
            'nombre' => 'Roles',
            'ruta'  => '/api/roles/create',
            'agregar' => 1,
            'listar' => 1,
            'eliminar' => 1,
            'editar' => 1
        ]);
        Permiso::create([
            'id' => 2,
            'nombre' => 'Departamentos',
            'ruta'  => '/api/departamentos/create',
            'agregar' => 1,
            'listar' => 1,
            'eliminar' => 1,
            'editar' => 1
        ]);
        Permiso::create([
            'id' => 3,
            'nombre' => 'Incidentes',
            'ruta'  => '/api/incidentes/create',
            'agregar' => 1,
            'listar' => 1,
            'eliminar' => 1,
            'editar' => 1
        ]);
    }
}
