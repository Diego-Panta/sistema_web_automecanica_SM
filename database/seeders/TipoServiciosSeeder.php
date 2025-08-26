<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposServicio = [
            ['nombre' => 'Mantenimiento Preventivo', 'descripcion' => 'Cambio de aceite, filtros y revisión general'],
            ['nombre' => 'Mantenimiento Correctivo', 'descripcion' => 'Reparación de fallas y averías'],
            ['nombre' => 'Cambio de Frenos', 'descripcion' => 'Sistema de frenos completo'],
            ['nombre' => 'Suspensión', 'descripcion' => 'Reparación y cambio de componentes de suspensión'],
            ['nombre' => 'Sistema Eléctrico', 'descripcion' => 'Diagnóstico y reparación de problemas eléctricos'],
            ['nombre' => 'Aire Acondicionado', 'descripcion' => 'Mantenimiento y reparación del sistema de aire'],
            ['nombre' => 'Transmisión', 'descripcion' => 'Reparación y cambio de transmisión'],
            ['nombre' => 'Motor', 'descripcion' => 'Reparación mayor del motor'],
            ['nombre' => 'Otros', 'descripcion' => 'Otros servicios no especificados'],
        ];

        foreach ($tiposServicio as $tipo) {
            DB::table('tipo_servicios')->insert([
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
