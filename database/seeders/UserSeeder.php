<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'José Mario Herbas',
            'cedula' => '8230432',
            'celular' => '75540850',
            'direccion' => 'Av/ Pentaguazu',
            'is_admin' => 1,
            'email' => 'j.mario18npa@gmail.com',
            'password' => Hash::make('jose'),
            'remember_token' => Str::random(10),
        ]);
        DB::table('users')->insert([
            'name' => 'Milenka Rojas',
            'cedula' => '123456',
            'celular' => '60808812',
            'direccion' => 'Av. Busch',
            'is_admin' => 1,
            'email' => 'mrojasgarnica1@gmail.com',
            'password' => Hash::make('milenka'),
            'remember_token' => Str::random(10),
        ]);
        DB::table('users')->insert([
            'name' => 'Nicolás Serovich',
            'cedula' => '123456',
            'celular' => '73371252',
            'direccion' => 'Av/ Alemana',
            'is_admin' => 0,
            'email' => 'cobubenjamin898@gmail.com',
            'password' => Hash::make('jose'),
            'remember_token' => Str::random(10),
        ]);
    }
}
