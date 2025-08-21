<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EstadoLead;

class EstadoLeadsSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['nombre_estado' => 'Nuevo'],
            ['nombre_estado' => 'Contactado'],
            ['nombre_estado' => 'Calificado'],
            ['nombre_estado' => 'No interesado'],
            ['nombre_estado' => 'Venta concretada'],
            ['nombre_estado' => 'Perdido'],
        ];

        foreach ($estados as $estado) {
            EstadoLead::create($estado);
        }
    }
}
