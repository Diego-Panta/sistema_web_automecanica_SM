<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoVehiculo;

class TipoVehiculosSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['nombre_tipo_vehiculo' => 'Sedán'],
            ['nombre_tipo_vehiculo' => 'Hatchback'],
            ['nombre_tipo_vehiculo' => 'SUV'],
            ['nombre_tipo_vehiculo' => 'Pickup'],
            ['nombre_tipo_vehiculo' => 'Van'],
            ['nombre_tipo_vehiculo' => 'Coupe'],
            ['nombre_tipo_vehiculo' => 'Convertible'],
        ];

        foreach ($tipos as $tipo) {
            TipoVehiculo::create($tipo);
        }
    }
}
