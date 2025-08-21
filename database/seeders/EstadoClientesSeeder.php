<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EstadoCliente;

class EstadoClientesSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['nombre_estado' => 'Prospecto'],
            ['nombre_estado' => 'Activo'],
            ['nombre_estado' => 'Inactivo'],
            ['nombre_estado' => 'Potencial'],
            ['nombre_estado' => 'VIP'],
            ['nombre_estado' => 'Moroso'],
            ['nombre_estado' => 'Suspendido'],
            ['nombre_estado' => 'Cancelado'],
        ];

        foreach ($estados as $estado) {
            EstadoCliente::create($estado);
        }
    }
}
