<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('servicios')->insert([
            ['nombre' => 'Express', 'descripcion' => 'Servicio básico de envio', 'precio_kilo' => 53,'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Premium', 'descripcion' => 'Servicio de buena calidad.','precio_kilo' => 70, 'created_at' => now(), 'updated_at' => now()],

            // Añade más servicios si es necesario
        ]);
    }
}
