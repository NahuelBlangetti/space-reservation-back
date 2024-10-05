<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',            // Nombre del usuario admin
            'email' => 'user@admin.com',    // Correo del usuario admin
            'password' => Hash::make('admin123'), // Contraseña (puedes cambiarla)
            'is_admin' => true,                // Establecer is_admin en true
        ]);
    }
}
