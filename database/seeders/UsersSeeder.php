<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserLaborale;
use App\Models\EstadoUser;
use App\Models\Sede;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener el estado "Activo"
        $estadoActivo = EstadoUser::where('nombre_estado', 'Activo')->first();

        // Obtener sedes
        $sedeChimbote1 = Sede::where('codigo_sede', 'ASM 1 - CH')->first();
        $sedeChimbote2 = Sede::where('codigo_sede', 'ASM 2 - CH')->first();
        $sedeHuaraz1 = Sede::where('codigo_sede', 'ASM 1 - HUA')->first();
        $sedeHuaraz2 = Sede::where('codigo_sede', 'ASM 2 - HUA')->first();

        // Usuario 1: Asesor de Ventas - Sede Chimbote 1
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
            'sede_id' => $sedeChimbote1->id, // NUEVO: Asignar sede
            'codigo_trabajador' => 'ASV001',
            'fecha_contratacion_inicio' => '2022-03-10',
            'fecha_contratacion_fin' => null, // Contrato indefinido
        ]);

        // Asignar rol de asesor ventas
        $user1->assignRole('asesor ventas');

        // Usuario 2: Marketing - Sede Chimbote 2
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
            'sede_id' => $sedeChimbote2->id, // NUEVO: Asignar sede
            'codigo_trabajador' => 'MKT001',
            'fecha_contratacion_inicio' => '2023-01-15',
            'fecha_contratacion_fin' => '2024-01-15', // Contrato por 1 año
        ]);

        // Asignar rol de marketing
        $user2->assignRole('marketing');

        // Usuario 3: Jefe de Repuestos - Sede Huaraz 1
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
            'sede_id' => $sedeHuaraz1->id, // NUEVO: Asignar sede
            'codigo_trabajador' => 'JRP001',
            'fecha_contratacion_inicio' => '2021-06-01',
            'fecha_contratacion_fin' => null, // Contrato indefinido
        ]);

        // Asignar rol de jefe repuestos
        $user3->assignRole('jefe repuestos');

        // Usuario 4: Asesor de Ventas - Sede Huaraz 2 (ejemplo adicional)
        $user4 = User::create([
            'name' => 'María Elena Vargas Ruiz',
            'email' => 'maria.vargas@empresa.com',
            'password' => Hash::make('password123'),
            'dni' => '74567890',
            'celular' => '945678901',
            'celular_alterno' => null,
            'email_personal' => 'maria.vargas@gmail.com',
            'fecha_nacimiento' => '1990-03-18',
            'direccion' => 'Av. Los Álamos 321, Huaraz',
        ]);

        UserLaborale::create([
            'user_id' => $user4->id,
            'estado_user_id' => $estadoActivo->id,
            'sede_id' => $sedeHuaraz2->id, // NUEVO: Asignar sede
            'codigo_trabajador' => 'ASV002',
            'fecha_contratacion_inicio' => '2023-05-20',
            'fecha_contratacion_fin' => null,
        ]);

        // Asignar rol de asesor ventas
        $user4->assignRole('asesor ventas');

        // Usuario 5: Marketing - Sede Huaraz 1 (ejemplo adicional)
        $user5 = User::create([
            'name' => 'Jorge Luis Medina Castro',
            'email' => 'jorge.medina@empresa.com',
            'password' => Hash::make('password123'),
            'dni' => '75678901',
            'celular' => '956789012',
            'celular_alterno' => '965432109',
            'email_personal' => 'jorge.medina@hotmail.com',
            'fecha_nacimiento' => '1987-12-05',
            'direccion' => 'Calle Los Eucaliptos 654, Huaraz',
        ]);

        UserLaborale::create([
            'user_id' => $user5->id,
            'estado_user_id' => $estadoActivo->id,
            'sede_id' => $sedeHuaraz1->id, // NUEVO: Asignar sede
            'codigo_trabajador' => 'MKT002',
            'fecha_contratacion_inicio' => '2022-09-10',
            'fecha_contratacion_fin' => '2023-09-10',
        ]);

        // Asignar rol de marketing
        $user5->assignRole('marketing');

        // Usuario Admin
        $adminUser = User::firstOrCreate(
            ['email' => 'diego.panta@empresa.com'],
            [
                'name' => 'Diego Panta',
                'password' => Hash::make('123'),
                'dni' => '87654321',
                'celular' => '912345678',
                'email_personal' => 'diego.panta@gmail.com',
                'fecha_nacimiento' => '1990-08-20',
                'direccion' => 'Calle Secundaria 456'
            ]
        );

        UserLaborale::create([
            'user_id' => $adminUser->id,
            'estado_user_id' => $estadoActivo->id,
            'sede_id' => $sedeChimbote1->id, // o la sede que prefieras
            'codigo_trabajador' => 'ADM001',
            'fecha_contratacion_inicio' => '2020-01-01',
            'fecha_contratacion_fin' => null,
        ]);

        // Asignar todos los roles al usuario admin
        $adminUser->assignRole(\Spatie\Permission\Models\Role::all());
    }
}
