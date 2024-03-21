<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departamento::create([
            'id' => 1,
            'nombre' => 'Informatica',
        ]);
        Departamento::create([
            'id' => 2,
            'nombre' => 'Finanzas',
        ]);
        Departamento::create([
            'id' => 3,
            'nombre' => 'Contabilidad',
        ]);
    }
}
