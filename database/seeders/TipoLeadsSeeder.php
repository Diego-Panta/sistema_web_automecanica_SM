<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoLead;

class TipoLeadsSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['nombre_tipo' => 'Compra'],
            ['nombre_tipo' => 'Repuesto'],
            ['nombre_tipo' => 'Postventa'],
        ];

        foreach ($tipos as $tipo) {
            TipoLead::create($tipo);
        }
    }
}
