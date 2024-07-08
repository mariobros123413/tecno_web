<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('almacen')->insert([
            ['nombre' => 'Bolivia', 'direccion' => 'Calle 1, Zona Central', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Colombia', 'direccion' => 'Calle 2, Zona Sur', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Venezuela', 'direccion' => 'Calle 3, Zona Este', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Argentina', 'direccion' => 'Calle 4, Zona Oeste', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Uruguay', 'direccion' => 'Calle 5, Zona Norte', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
