<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('servicio')->insert([
            'nombre' => 'Normal',
            'descripcion' => 'Envío normal (20 días de duración)',
            'precio_kilo' => 35.0,
        ]);
        DB::table('servicio')->insert([
            'nombre' => 'Envío Express',
            'descripcion' => 'Envío prioritario (7 días de duración)',
            'precio_kilo' => 45.0,
        ]);
    }
}
