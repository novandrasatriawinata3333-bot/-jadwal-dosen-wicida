<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwal_id',
        'user_id',
        'nama_mahasiswa',
        'nim',
        'email_mahasiswa',
        'no_hp',
        'tanggal_booking',
        'keperluan',
        'status',
        'alasan_reject',
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}
