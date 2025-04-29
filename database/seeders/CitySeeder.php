<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        City::insert([
            ['name' => 'Guarulhos', 'state' => 'SP'],
            ['name' => 'São Paulo', 'state' => 'SP'],
            ['name' => 'Trindade', 'state' => 'RJ'],
            ['name' => 'Vilage', 'state' => 'SC'],
            ['name' => 'Extrema', 'state' => 'MG'],
        ]);
    }
}
