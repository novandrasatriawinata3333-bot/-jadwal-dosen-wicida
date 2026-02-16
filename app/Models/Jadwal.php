<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'kegiatan',
        'keterangan',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'jam_mulai' => 'datetime:H:i',
            'jam_selesai' => 'datetime:H:i',
        ];
    }

    /**
     * RELATIONSHIPS
     */
    
    // Jadwal belongs to User (dosen)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * SCOPES
     */
    
    // Filter by hari
    public function scopeHari($query, $hari)
    {
        return $query->where('hari', $hari);
    }

    // Filter by kegiatan
    public function scopeKegiatan($query, $kegiatan)
    {
        return $query->where('kegiatan', $kegiatan);
    }

    // Get jadwal for today
    public function scopeToday($query)
    {
        $hari = ['Sunday' => '', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 
                 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat'];
        
        $today = $hari[date('l')] ?? '';
        
        return $query->where('hari', $today);
    }

    /**
     * ACCESSORS
     */
    
    // Get kegiatan icon
    public function getKegiatanIconAttribute()
    {
        return match($this->kegiatan) {
            'Mengajar' => '📚',
            'Konsultasi' => '💬',
            'Rapat' => '👥',
            'Lainnya' => '📌',
            default => '📅',
        };
    }

    // Get formatted time range
    public function getWaktuAttribute()
    {
        return date('H:i', strtotime($this->jam_mulai)) . ' - ' . 
               date('H:i', strtotime($this->jam_selesai));
    }
}
