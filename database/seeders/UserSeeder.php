<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Dr. Budi Santoso, M.T.',
                'email' => 'budi@lab-wicida.ac.id',
                'nip' => '198501012010011001',
                'role' => 'kepala_lab',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Siti Nurhaliza, S.Kom., M.Kom.',
                'email' => 'siti@lab-wicida.ac.id',
                'nip' => '199002022015042001',
                'role' => 'staf',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Ahmad Fadli, S.T., M.Eng.',
                'email' => 'ahmad@lab-wicida.ac.id',
                'nip' => '198803032012031002',
                'role' => 'staf',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Rina Kartika, S.Si., M.T.',
                'email' => 'rina@lab-wicida.ac.id',
                'nip' => '199105052016052001',
                'role' => 'staf',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
