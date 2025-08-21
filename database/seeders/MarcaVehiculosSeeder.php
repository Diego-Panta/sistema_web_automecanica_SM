<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MarcaVehiculo;

class MarcaVehiculosSeeder extends Seeder
{
    public function run(): void
    {
        $marcas = [
            ['nombre_marca' => 'Toyota'],
            ['nombre_marca' => 'Nissan'],
            ['nombre_marca' => 'Hyundai'],
            ['nombre_marca' => 'Kia'],
            ['nombre_marca' => 'Chevrolet'],
            ['nombre_marca' => 'Mitsubishi'],
            ['nombre_marca' => 'Volkswagen'],
            ['nombre_marca' => 'Suzuki'],
            ['nombre_marca' => 'Ford'],
            ['nombre_marca' => 'Honda'],
        ];

        foreach ($marcas as $marca) {
            MarcaVehiculo::create($marca);
        }
    }
}
