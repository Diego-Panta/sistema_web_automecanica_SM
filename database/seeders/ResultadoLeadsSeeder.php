<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ResultadoLead;

class ResultadoLeadsSeeder extends Seeder
{
    public function run(): void
    {
        $resultados = [
            ['nombre_resultado' => 'Agendado'],
            ['nombre_resultado' => 'No contesta'],
            ['nombre_resultado' => 'Volver a llamar'],
            ['nombre_resultado' => 'Cotización enviada'],
            ['nombre_resultado' => 'Visita agendada'],
            ['nombre_resultado' => 'Venta concretada'],
            ['nombre_resultado' => 'No interesado'],
        ];

        foreach ($resultados as $resultado) {
            ResultadoLead::create($resultado);
        }
    }
}
