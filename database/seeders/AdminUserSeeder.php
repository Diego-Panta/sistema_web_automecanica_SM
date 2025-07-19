<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
        'name' => 'Ana García',
        'email' => 'ana.garcia@empresa.com',
        'password' => Hash::make('password123'),
        'dni' => '87654321',
        'celular' => '912345678',
        'email_personal' => 'ana.garcia@gmail.com',
        'fecha_nacimiento' => '1990-08-20',
        'direccion' => 'Calle Secundaria 456'
    ]);
    }
}
