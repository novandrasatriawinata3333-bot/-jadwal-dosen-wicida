<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nama_mahasiswa',
        'email_mahasiswa',
        'nim_mahasiswa',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'keperluan',
        'status',
        'alasan_reject',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_booking' => 'date',
            'jam_mulai' => 'datetime:H:i',
            'jam_selesai' => 'datetime:H:i',
        ];
    }

    /**
     * RELATIONSHIPS
     */
    
    // Booking belongs to User (dosen)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * SCOPES
     */
    
    // Get pending bookings
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Get approved bookings
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Get rejected bookings
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Get upcoming bookings (tanggal >= hari ini)
    public function scopeUpcoming($query)
    {
        return $query->where('tanggal_booking', '>=', today());
    }

    // Get past bookings
    public function scopePast($query)
    {
        return $query->where('tanggal_booking', '<', today());
    }

    /**
     * ACCESSORS
     */
    
    // Get status badge color
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'pending' => 'badge-warning',
            'approved' => 'badge-success',
            'rejected' => 'badge-error',
            default => 'badge-ghost',
        };
    }

    // Get status label
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => '⏳ Menunggu',
            'approved' => '✅ Disetujui',
            'rejected' => '❌ Ditolak',
            default => 'Unknown',
        };
    }

    // Get formatted date
    public function getTanggalFormatAttribute()
    {
        return $this->tanggal_booking->translatedFormat('d F Y');
    }

    // Get formatted time range
    public function getWaktuAttribute()
    {
        return date('H:i', strtotime($this->jam_mulai)) . ' - ' . 
               date('H:i', strtotime($this->jam_selesai));
    }

    // Check if booking is today
    public function getIstodayAttribute()
    {
        return $this->tanggal_booking->isToday();
    }

    // Check if booking is in the future
    public function getIsFutureAttribute()
    {
        return $this->tanggal_booking->isFuture();
    }
}
