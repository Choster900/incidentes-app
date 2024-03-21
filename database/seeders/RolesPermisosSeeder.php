<?php

namespace Database\Seeders;

use App\Models\RolPermiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RolPermiso::create([
            'id' => 1,
            'rol_id' => 1,
            'permiso_id' => 1,
        ]);
        RolPermiso::create([
            'id' => 2,
            'rol_id' => 2,
            'permiso_id' => 3,
        ]);
    }
}
