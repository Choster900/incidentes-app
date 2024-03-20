<?php

namespace Database\Seeders;

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
        //
        $faker = Faker::create();
        for ($i = 0; $i < 50; $i++) {
            DB::table("departamentos")->insert(
                array(
                    'id'           => $faker->unique()->randomNumber,
                    'departamento' => $faker->word,
                    'created_at'   => Carbon::now(),
                    'updated_at'   => Carbon::now()
                )
            );
        }
    }
}
