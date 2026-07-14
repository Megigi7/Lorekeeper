<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => '7megigi7@gmail.com'], // 👈 Pon aquí tu correo electrónico de acceso
            [
                'name' => 'Admin',               // 👈 Tu nombre de usuario
                'password' => Hash::make('admin'), // 👈 Pon aquí tu contraseña segura
                'is_admin' => true,              // Te damos el superpoder de administradora
            ]
        );
    }
}