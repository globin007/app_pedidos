<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'codigo_trabajador' => '001',
                'name' => 'Usuario Uno',
                'email' => 'encargado@gmail.com',
                'telefono' => '1234567890',
                'puesto' => '-',
                'rol' => 'Encargado',
                'email_verified_at' => now(),
                'password' => Hash::make('encargado'),
                'remember_token' => null,
                'current_team_id' => null,
                'profile_photo_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo_trabajador' => '002',
                'name' => 'Usuario Dos',
                'email' => 'vendedor@gmail.com',
                'telefono' => '0987654321',
                'puesto' => '-',
                'rol' => 'Vendedor',
                'email_verified_at' => now(),
                'password' => Hash::make('vendedor'),
                'remember_token' => null,
                'current_team_id' => null,
                'profile_photo_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo_trabajador' => '003',
                'name' => 'Usuario Tres',
                'email' => 'delivery@gmail.com',
                'telefono' => '0987652321',
                'puesto' => '-',
                'rol' => 'Delivery',
                'email_verified_at' => now(),
                'password' => Hash::make('delivery'),
                'remember_token' => null,
                'current_team_id' => null,
                'profile_photo_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo_trabajador' => '004',
                'name' => 'Usuario Cuatro',
                'email' => 'repartidor@gmail.com',
                'telefono' => '0984654321',
                'puesto' => '-',
                'rol' => 'Repartidor',
                'email_verified_at' => now(),
                'password' => Hash::make('repartidor'),
                'remember_token' => null,
                'current_team_id' => null,
                'profile_photo_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
