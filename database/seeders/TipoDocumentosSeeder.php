<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDocumentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposDocumento = [
            ['nombre' => 'DNI'],
            ['nombre' => 'CE (Carné de Extranjería)'],
            ['nombre' => 'Pasaporte'],
            ['nombre' => 'RUC'],
            ['nombre' => 'Otros'],
        ];

        foreach ($tiposDocumento as $tipo) {
            DB::table('tipo_documentos')->insert([
                'nombre' => $tipo['nombre'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
