<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserLaborale;
use App\Models\EstadoUser;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener el estado "Activo"
        $estadoActivo = EstadoUser::where('nombre_estado', 'Activo')->first();

        // Usuario 1: Asesor de Ventas
        $user1 = User::create([
            'name' => 'Carlos Rodríguez Méndez',
            'email' => 'carlos.rodriguez@empresa.com',
            'password' => Hash::make('password123'),
            'dni' => '71234567',
            'celular' => '912345678',
            'celular_alterno' => '987654321',
            'email_personal' => 'carlos.rodriguez@gmail.com',
            'fecha_nacimiento' => '1988-05-15',
            'direccion' => 'Av. Los Olivos 123, Lima',
        ]);

        UserLaborale::create([
            'user_id' => $user1->id,
            'estado_user_id' => $estadoActivo->id,
            'codigo_trabajador' => 'ASV001',
            'fecha_contratacion_inicio' => '2022-03-10',
            'fecha_contratacion_fin' => null, // Contrato indefinido
        ]);

        // Asignar rol de asesor ventas
        $user1->assignRole('asesor ventas');

        // Usuario 2: Marketing
        $user2 = User::create([
            'name' => 'Ana María Torres López',
            'email' => 'ana.torres@empresa.com',
            'password' => Hash::make('password123'),
            'dni' => '72345678',
            'celular' => '923456789',
            'celular_alterno' => null,
            'email_personal' => 'ana.torres@hotmail.com',
            'fecha_nacimiento' => '1992-11-22',
            'direccion' => 'Calle Las Magnolias 456, Surco',
        ]);

        UserLaborale::create([
            'user_id' => $user2->id,
            'estado_user_id' => $estadoActivo->id,
            'codigo_trabajador' => 'MKT001',
            'fecha_contratacion_inicio' => '2023-01-15',
            'fecha_contratacion_fin' => '2024-01-15', // Contrato por 1 año
        ]);

        // Asignar rol de marketing
        $user2->assignRole('marketing');

        // Usuario 3: Jefe de Repuestos
        $user3 = User::create([
            'name' => 'Luis Fernando García Silva',
            'email' => 'luis.garcia@empresa.com',
            'password' => Hash::make('password123'),
            'dni' => '73456789',
            'celular' => '934567890',
            'celular_alterno' => '976543210',
            'email_personal' => 'luis.garcia@yahoo.com',
            'fecha_nacimiento' => '1985-08-30',
            'direccion' => 'Jr. Los Pinos 789, La Molina',
        ]);

        UserLaborale::create([
            'user_id' => $user3->id,
            'estado_user_id' => $estadoActivo->id,
            'codigo_trabajador' => 'JRP001',
            'fecha_contratacion_inicio' => '2021-06-01',
            'fecha_contratacion_fin' => null, // Contrato indefinido
        ]);

        // Asignar rol de jefe repuestos
        $user3->assignRole('jefe repuestos');
    }
}
