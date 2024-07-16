<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlmacenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('almacen')->insert([
            'nombre' => 'Boca Gardens',
            'direccion' => '9691 Boca Gardens Cir N APT D Boca Raton, FL 33496-1782 United States',
            'tax' => 7.0
        ]);
        DB::table('almacen')->insert([
            'nombre' => 'Doral Florida',
            'direccion' => '11118 NW 44th Ter Doral, FL 33178-4217 United States',
            'tax' => 7.0
        ]);
        DB::table('almacen')->insert([
            'nombre' => 'Miami Lakeway S',
            'direccion' => '6365 Miami Lakeway S Miami Lakes, FL 33014-2742 United States',
            'tax' => 7.0
        ]);
        DB::table('almacen')->insert([
            'nombre' => 'Oregon',
            'direccion' => 'OBO LOGISTICS 12540 SW Leveton Dr #F7511 Tualatin, OR 97062-6070 United States',
            'tax' => 0.0
        ]);
    }
}
