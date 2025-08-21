<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Turno;

class TurnosSeeder extends Seeder
{
    public function run(): void
    {
        $turnos = [
            [
                'nombre_turno' => 'Mañana HUA',
                'hora_inicio' => '08:00:00',
                'hora_fin' => '13:00:00'
            ],
            [
                'nombre_turno' => 'Tarde - HUA',
                'hora_inicio' => '13:00:00',
                'hora_fin' => '18:00:00'
            ],
            [
                'nombre_turno' => 'Mañana CH',
                'hora_inicio' => '09:00:00',
                'hora_fin' => '13:00:00'
            ],
            [
                'nombre_turno' => 'Tarde - CH',
                'hora_inicio' => '13:00:00',
                'hora_fin' => '19:00:00'
            ],
            [
                'nombre_turno' => 'Completo HUA',
                'hora_inicio' => '08:00:00',
                'hora_fin' => '18:00:00'
            ],
            [
                'nombre_turno' => 'Completo CH',
                'hora_inicio' => '08:00:00',
                'hora_fin' => '19:00:00'
            ],
        ];

        foreach ($turnos as $turno) {
            Turno::create($turno);
        }
    }
}
