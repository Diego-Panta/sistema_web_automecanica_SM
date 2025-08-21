<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accione;

class AccionesSeeder extends Seeder
{
    public function run(): void
    {
        $acciones = [
            [
                'nombre_accion' => 'Llamada inicial',
                'descripcion' => 'Primer contacto telefónico con el lead'
            ],
            [
                'nombre_accion' => 'Envío de cotización',
                'descripcion' => 'Envío de cotización por email'
            ],
            [
                'nombre_accion' => 'Seguimiento',
                'descripcion' => 'Seguimiento posterior al primer contacto'
            ],
            [
                'nombre_accion' => 'Agendamiento de visita',
                'descripcion' => 'Coordinación de visita a showroom'
            ],
            [
                'nombre_accion' => 'Test drive',
                'descripcion' => 'Coordinación de test drive'
            ],
            [
                'nombre_accion' => 'Cierre de venta',
                'descripcion' => 'Proceso de cierre de venta'
            ],
        ];

        foreach ($acciones as $accion) {
            Accione::create($accion);
        }
    }
}
