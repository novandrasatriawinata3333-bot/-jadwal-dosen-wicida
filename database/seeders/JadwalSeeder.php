<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\User;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        // Gunakan delete() bukan truncate()
        Jadwal::query()->delete();
        
        $users = User::all();
        
        $jadwalData = [
            ['hari' => 'Senin', 'waktu_mulai' => '08:00', 'waktu_selesai' => '10:00', 'ruangan' => 'Lab A'],
            ['hari' => 'Senin', 'waktu_mulai' => '13:00', 'waktu_selesai' => '15:00', 'ruangan' => 'Lab B'],
            ['hari' => 'Rabu', 'waktu_mulai' => '09:00', 'waktu_selesai' => '11:00', 'ruangan' => 'Lab A'],
            ['hari' => 'Jumat', 'waktu_mulai' => '14:00', 'waktu_selesai' => '16:00', 'ruangan' => 'Lab C'],
        ];

        foreach ($users->take(3) as $user) {
            foreach ($jadwalData as $jadwal) {
                Jadwal::create([
                    'user_id' => $user->id,
                    'hari' => $jadwal['hari'],
                    'waktu_mulai' => $jadwal['waktu_mulai'],
                    'waktu_selesai' => $jadwal['waktu_selesai'],
                    'ruangan' => $jadwal['ruangan'],
                    'keterangan' => 'Jam konsultasi tersedia',
                ]);
            }
        }
    }
}
