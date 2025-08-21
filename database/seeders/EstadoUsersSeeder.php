<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EstadoUser;

class EstadoUsersSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['nombre_estado' => 'Activo'],
            ['nombre_estado' => 'Inactivo'],
            ['nombre_estado' => 'Vacaciones'],
            ['nombre_estado' => 'Licencia'],
            ['nombre_estado' => 'Suspendido'],
        ];

        foreach ($estados as $estado) {
            EstadoUser::create($estado);
        }
    }
}
