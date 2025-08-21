<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Canale;

class CanalesSeeder extends Seeder
{
    public function run(): void
    {
        $canales = [
            ['nombre_canal' => 'Web Oficial'],
            ['nombre_canal' => 'Facebook Ads'],
            ['nombre_canal' => 'Google Ads'],
            ['nombre_canal' => 'Instagram'],
            ['nombre_canal' => 'Tik Tok'],
            ['nombre_canal' => 'Eventos'],
            ['nombre_canal' => 'Referidos'],
            ['nombre_canal' => 'Base de datos antigua'],
        ];

        foreach ($canales as $canal) {
            Canale::create($canal);
        }
    }
}
