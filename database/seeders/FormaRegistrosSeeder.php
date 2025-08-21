<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FormaRegistro;

class FormaRegistrosSeeder extends Seeder
{
    public function run(): void
    {
        $formas = [
            ['nombre_forma' => 'Manual'],
            ['nombre_forma' => 'Automática'],
        ];

        foreach ($formas as $forma) {
            FormaRegistro::create($forma);
        }
    }
}
