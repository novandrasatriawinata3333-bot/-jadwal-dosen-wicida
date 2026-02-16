<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Status;
use App\Models\Jadwal;
use App\Models\Booking;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::create([
            'name' => 'Administrator Lab WICIDA',
            'email' => 'admin@lab-wicida.ac.id',
            'password' => bcrypt('admin123'),
            'nip' => null,
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 2. Create Dosen 1 - Kepala Lab (Dr. Budi Santoso)
        $budi = User::create([
            'name' => 'Dr. Budi Santoso, M.Kom',
            'email' => 'budi@lab-wicida.ac.id',
            'password' => bcrypt('password'),
            'nip' => '198501151990031001',
            'role' => 'kepala_lab',
            'email_verified_at' => now(),
        ]);

        Status::create([
            'user_id' => $budi->id,
            'status' => 'Ada',
            'updated_at_iot' => now(),
        ]);

        // Jadwal Budi - Senin
        Jadwal::create([
            'user_id' => $budi->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'ruangan' => 'Lab WICIDA 101',
            'kegiatan' => 'Mengajar',
            'keterangan' => 'Praktikum Artificial Intelligence',
        ]);

        Jadwal::create([
            'user_id' => $budi->id,
            'hari' => 'Senin',
            'jam_mulai' => '13:00',
            'jam_selesai' => '15:00',
            'ruangan' => 'Lab WICIDA 101',
            'kegiatan' => 'Konsultasi',
            'keterangan' => 'Konsultasi mahasiswa bimbingan',
        ]);

        // Jadwal Budi - Rabu
        Jadwal::create([
            'user_id' => $budi->id,
            'hari' => 'Rabu',
            'jam_mulai' => '09:00',
            'jam_selesai' => '11:00',
            'ruangan' => 'Ruang Rapat Lab WICIDA',
            'kegiatan' => 'Rapat',
            'keterangan' => 'Rapat koordinasi lab mingguan',
        ]);

        Jadwal::create([
            'user_id' => $budi->id,
            'hari' => 'Rabu',
            'jam_mulai' => '14:00',
            'jam_selesai' => '16:00',
            'ruangan' => 'Lab WICIDA 101',
            'kegiatan' => 'Mengajar',
            'keterangan' => 'Deep Learning',
        ]);

        // 3. Create Dosen 2 - Staf (Ir. Siti Nurhayati)
        $siti = User::create([
            'name' => 'Ir. Siti Nurhayati, M.T',
            'email' => 'siti@lab-wicida.ac.id',
            'password' => bcrypt('password'),
            'nip' => '198703202015032004',
            'role' => 'staf',
            'email_verified_at' => now(),
        ]);

        Status::create([
            'user_id' => $siti->id,
            'status' => 'Mengajar',
            'updated_at_iot' => now(),
        ]);

        // Jadwal Siti - Selasa
        Jadwal::create([
            'user_id' => $siti->id,
            'hari' => 'Selasa',
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'ruangan' => 'Lab WICIDA 102',
            'kegiatan' => 'Mengajar',
            'keterangan' => 'Praktikum Machine Learning',
        ]);

        Jadwal::create([
            'user_id' => $siti->id,
            'hari' => 'Selasa',
            'jam_mulai' => '10:30',
            'jam_selesai' => '12:00',
            'ruangan' => 'Lab WICIDA 102',
            'kegiatan' => 'Konsultasi',
        ]);

        // Jadwal Siti - Kamis
        Jadwal::create([
            'user_id' => $siti->id,
            'hari' => 'Kamis',
            'jam_mulai' => '13:00',
            'jam_selesai' => '15:00',
            'ruangan' => 'Lab WICIDA 102',
            'kegiatan' => 'Mengajar',
            'keterangan' => 'Data Mining & Analytics',
        ]);

        // 4. Create Dosen 3 - Staf (Andriana Kusuma)
        $andriana = User::create([
            'name' => 'Andriana Kusuma, S.Kom, M.Cs',
            'email' => 'andriana@lab-wicida.ac.id',
            'password' => bcrypt('password'),
            'nip' => '199005152018032002',
            'role' => 'staf',
            'email_verified_at' => now(),
        ]);

        Status::create([
            'user_id' => $andriana->id,
            'status' => 'Konsultasi',
            'updated_at_iot' => now(),
        ]);

        // Jadwal Andriana - Rabu
        Jadwal::create([
            'user_id' => $andriana->id,
            'hari' => 'Rabu',
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'ruangan' => 'Lab WICIDA 103',
            'kegiatan' => 'Mengajar',
            'keterangan' => 'Computer Vision',
        ]);

        // Jadwal Andriana - Kamis
        Jadwal::create([
            'user_id' => $andriana->id,
            'hari' => 'Kamis',
            'jam_mulai' => '09:00',
            'jam_selesai' => '11:00',
            'ruangan' => 'Lab WICIDA 103',
            'kegiatan' => 'Konsultasi',
            'keterangan' => 'Open consultation for all students',
        ]);

        Jadwal::create([
            'user_id' => $andriana->id,
            'hari' => 'Kamis',
            'jam_mulai' => '14:00',
            'jam_selesai' => '16:00',
            'ruangan' => 'Lab WICIDA 103',
            'kegiatan' => 'Mengajar',
            'keterangan' => 'Natural Language Processing',
        ]);

        // Jadwal Andriana - Jumat
        Jadwal::create([
            'user_id' => $andriana->id,
            'hari' => 'Jumat',
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'ruangan' => 'Lab WICIDA 103',
            'kegiatan' => 'Konsultasi',
        ]);

        // 5. Create Sample Bookings
        Booking::create([
            'user_id' => $budi->id,
            'nama_mahasiswa' => 'Ahmad Rizki',
            'email_mahasiswa' => 'ahmad.rizki@student.ac.id',
            'nim_mahasiswa' => '2021110001',
            'tanggal_booking' => now()->addDays(2),
            'jam_mulai' => '13:30',
            'jam_selesai' => '14:30',
            'keperluan' => 'Konsultasi skripsi tentang implementasi CNN untuk deteksi objek',
            'status' => 'pending',
        ]);

        Booking::create([
            'user_id' => $siti->id,
            'nama_mahasiswa' => 'Siti Aisyah',
            'email_mahasiswa' => 'siti.aisyah@student.ac.id',
            'nim_mahasiswa' => '2021110045',
            'tanggal_booking' => now()->addDays(3),
            'jam_mulai' => '10:30',
            'jam_selesai' => '11:30',
            'keperluan' => 'Diskusi hasil analisis data untuk tugas akhir',
            'status' => 'approved',
        ]);

        Booking::create([
            'user_id' => $andriana->id,
            'nama_mahasiswa' => 'Budi Hartono',
            'email_mahasiswa' => 'budi.hartono@student.ac.id',
            'nim_mahasiswa' => '2021110078',
            'tanggal_booking' => now()->addDays(1),
            'jam_mulai' => '09:00',
            'jam_selesai' => '10:00',
            'keperluan' => 'Konsultasi implementasi YOLO untuk project CV',
            'status' => 'rejected',
            'alasan_reject' => 'Jadwal bentrok dengan mengajar. Silakan pilih waktu lain.',
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📧 Admin: admin@lab-wicida.ac.id | Password: admin123');
        $this->command->info('📧 Dosen: budi@lab-wicida.ac.id | Password: password');
    }
}
