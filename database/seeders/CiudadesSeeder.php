<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ciudade;

class CiudadesSeeder extends Seeder
{
    public function run(): void
    {
        $ciudades = [
            ['nombre' => 'Lima', 'region' => 'Lima Metropolitana'],
            ['nombre' => 'Arequipa', 'region' => 'Arequipa'],
            ['nombre' => 'Trujillo', 'region' => 'La Libertad'],
            ['nombre' => 'Chiclayo', 'region' => 'Lambayeque'],
            ['nombre' => 'Piura', 'region' => 'Piura'],
            ['nombre' => 'Cusco', 'region' => 'Cusco'],
            ['nombre' => 'Ica', 'region' => 'Ica'],
            ['nombre' => 'Huancayo', 'region' => 'Junín'],
            ['nombre' => 'Tacna', 'region' => 'Tacna'],
            ['nombre' => 'Puno', 'region' => 'Puno'],
            ['nombre' => 'Chimbote', 'region' => 'Ancash'],
            ['nombre' => 'Huaraz', 'region' => 'Ancash'],
        ];

        foreach ($ciudades as $ciudad) {
            Ciudade::create($ciudad);
        }
    }
}
