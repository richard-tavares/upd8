<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\City;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'name' => 'Wesley Barbosa',
                'cpf' => '378.658.658-00',
                'birth_date' => '1990-06-06',
                'gender' => 'M',
                'address' => 'Rua 1',
                'city_id' => City::where('name', 'Guarulhos')->first()->id,
            ],
            [
                'name' => 'Ricardo Menezes',
                'cpf' => '326.652.654-00',
                'birth_date' => '1980-06-06',
                'gender' => 'M',
                'address' => 'Rua 2',
                'city_id' => City::where('name', 'São Paulo')->first()->id,
            ],
            [
                'name' => 'Margaret Hamil',
                'cpf' => '235.326.148-12',
                'birth_date' => '1995-06-06',
                'gender' => 'F',
                'address' => 'Rua 3',
                'city_id' => City::where('name', 'Trindade')->first()->id,
            ],
            [
                'name' => 'Joan Clarke',
                'cpf' => '032.324.674-78',
                'birth_date' => '2000-06-06',
                'gender' => 'M',
                'address' => 'Rua 4',
                'city_id' => City::where('name', 'Vilage')->first()->id,
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
