<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sede;
use App\Models\Ciudade;

class SedesSeeder extends Seeder
{
    public function run(): void
    {
        $ciudadChimbote = Ciudade::where('nombre', 'Chimbote')->first();
        $ciudadHuaraz = Ciudade::where('nombre', 'Huaraz')->first();

        $sedes = [
            [
                'codigo_sede' => 'ASM 1 - CH',
                'ciudad_id' => $ciudadChimbote->id,
                'nombre_sede' => 'Sede Chimbote 1',
                'direccion' => 'Av. Enrique Meiggs #1141, Chimbote.',
                'descripcion' => 'Sede principal de Chimbote',
                'capacidad' => 50
            ],
            [
                'codigo_sede' => 'ASM 2 - CH',
                'ciudad_id' => $ciudadChimbote->id,
                'nombre_sede' => 'Sede Chimbote 2',
                'direccion' => 'Av. Enrique Meiggs #1115, Chimbote.',
                'descripcion' => 'Sede secundario de Chimbote',
                'capacidad' => 30
            ],
            [
                'codigo_sede' => 'ASM 1 - HUA',
                'ciudad_id' => $ciudadHuaraz->id,
                'nombre_sede' => 'Sede Huaraz 1',
                'direccion' => 'Av. Centenario #4105, Independencia  Huaraz.',
                'descripcion' => 'Sede principal de Huaraz',
                'capacidad' => 25
            ],
            [
                'codigo_sede' => 'ASM 2 - HUA',
                'ciudad_id' => $ciudadHuaraz->id,
                'nombre_sede' => 'Sede Huaraz 2',
                'direccion' => 'Carretera Huaraz Monterrey KM 3.2, Independencia.',
                'descripcion' => 'Sede secundario de Huaraz',
                'capacidad' => 30
            ],
        ];

        foreach ($sedes as $sede) {
            Sede::create($sede);
        }
    }
}
