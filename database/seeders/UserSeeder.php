<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Criar usuário de teste
        User::updateOrCreate(
            ['email' => 'teste@bluefish.com'],
            [
                'name' => 'Usuário Teste',
                'email' => 'teste@bluefish.com',
                'password' => Hash::make('123456'),
            ]
        );

        // Criar outro usuário de teste
        User::updateOrCreate(
            ['email' => 'admin@bluefish.com'],
            [
                'name' => 'Administrador',
                'email' => 'admin@bluefish.com',
                'password' => Hash::make('admin123'),
            ]
        );
    }
}
