<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MedioContacto;

class MedioContactosSeeder extends Seeder
{
    public function run(): void
    {
        $medios = [
            [
                'nombre_medio' => 'WhatsApp',
                'descripcion' => 'Contacto a través de WhatsApp'
            ],
            [
                'nombre_medio' => 'Llamada telefónica',
                'descripcion' => 'Contacto por llamada telefónica'
            ],
            [
                'nombre_medio' => 'Email',
                'descripcion' => 'Contacto por correo electrónico'
            ],
            [
                'nombre_medio' => 'Visita en tienda',
                'descripcion' => 'Cliente visitó la tienda físicamente'
            ],
            [
                'nombre_medio' => 'Facebook',
                'descripcion' => 'Contacto a través de Facebook'
            ],
            [
                'nombre_medio' => 'Instagram',
                'descripcion' => 'Contacto a través de Instagram'
            ],
        ];

        foreach ($medios as $medio) {
            MedioContacto::create($medio);
        }
    }
}
