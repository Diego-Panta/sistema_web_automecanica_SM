<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/


        $this->call([
            EstadoUsersSeeder::class,
            EstadoLeadsSeeder::class,
            EstadoClientesSeeder::class,
            TipoDocumentosSeeder::class,
            TipoVehiculosSeeder::class,
            MarcaVehiculosSeeder::class,
            MedioContactosSeeder::class,
            CiudadesSeeder::class,
            FormaRegistrosSeeder::class,
            ResultadoLeadsSeeder::class,
            TipoLeadsSeeder::class,
            CanalesSeeder::class,
            TurnosSeeder::class,
            AccionesSeeder::class,
            TipoServiciosSeeder::class,
            SedesSeeder::class,
            ModeloVehiculosSeeder::class,
            RolePermissionSeeder::class,
            AdminUserSeeder::class,
            UsersSeeder::class,
        ]);
    }
}
