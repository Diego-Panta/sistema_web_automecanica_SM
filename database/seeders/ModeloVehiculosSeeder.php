<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ModeloVehiculo;
use App\Models\MarcaVehiculo;
use App\Models\TipoVehiculo;

class ModeloVehiculosSeeder extends Seeder
{
    public function run(): void
    {
        $toyota = MarcaVehiculo::where('nombre_marca', 'Toyota')->first();
        $nissan = MarcaVehiculo::where('nombre_marca', 'Nissan')->first();
        $hyundai = MarcaVehiculo::where('nombre_marca', 'Hyundai')->first();
        
        $sedan = TipoVehiculo::where('nombre_tipo_vehiculo', 'Sedán')->first();
        $suv = TipoVehiculo::where('nombre_tipo_vehiculo', 'SUV')->first();
        $hatchback = TipoVehiculo::where('nombre_tipo_vehiculo', 'Hatchback')->first();
        $pickup = TipoVehiculo::where('nombre_tipo_vehiculo', 'Pickup')->first();

        $modelos = [
            [
                'marca_id' => $toyota->id,
                'tipo_id' => $sedan->id,
                'nombre_modelo' => 'Corolla'
            ],
            [
                'marca_id' => $toyota->id,
                'tipo_id' => $suv->id,
                'nombre_modelo' => 'RAV4'
            ],
            [
                'marca_id' => $toyota->id,
                'tipo_id' => $pickup->id,
                'nombre_modelo' => 'Hilux'
            ],
            [
                'marca_id' => $nissan->id,
                'tipo_id' => $sedan->id,
                'nombre_modelo' => 'Sentra'
            ],
            [
                'marca_id' => $nissan->id,
                'tipo_id' => $suv->id,
                'nombre_modelo' => 'X-Trail'
            ],
            [
                'marca_id' => $hyundai->id,
                'tipo_id' => $hatchback->id,
                'nombre_modelo' => 'i20'
            ],
            [
                'marca_id' => $hyundai->id,
                'tipo_id' => $suv->id,
                'nombre_modelo' => 'Tucson'
            ],
            [
                'marca_id' => $hyundai->id,
                'tipo_id' => $sedan->id,
                'nombre_modelo' => 'Elantra'
            ],
        ];

        foreach ($modelos as $modelo) {
            ModeloVehiculo::create($modelo);
        }
    }
}
