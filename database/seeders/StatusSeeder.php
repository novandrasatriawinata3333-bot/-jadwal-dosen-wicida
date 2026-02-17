<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;
use App\Models\User;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $statuses = ['Ada', 'Tidak Ada', 'Rapat', 'Mengajar'];

        foreach ($users as $user) {
            Status::updateOrCreate(
                ['user_id' => $user->id], // Cari berdasarkan user_id
                [
                    'status' => $statuses[array_rand($statuses)],
                    'last_updated' => now(),
                ]
            );
        }
    }
}
