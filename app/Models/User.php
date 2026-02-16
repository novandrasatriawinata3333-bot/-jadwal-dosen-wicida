<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nip',
        'photo',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * RELATIONSHIPS
     */
    
    // User has many Jadwal
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class)->orderBy('hari')->orderBy('jam_mulai');
    }

    // User has one Status
    public function status()
    {
        return $this->hasOne(Status::class);
    }

    // User has many Bookings (sebagai dosen)
    public function bookings()
    {
        return $this->hasMany(Booking::class)->latest();
    }

    /**
     * SCOPES
     */
    
    // Scope untuk query dosen saja (kepala_lab dan staf)
    public function scopeDosen($query)
    {
        return $query->whereIn('role', ['kepala_lab', 'staf']);
    }

    // Scope untuk query admin
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * ACCESSORS & MUTATORS
     */
    
    // Get status badge color
    public function getStatusBadgeColorAttribute()
    {
        if (!$this->status) return 'badge-ghost';
        
        return match($this->status->status) {
            'Ada' => 'badge-success',
            'Mengajar' => 'badge-warning',
            'Konsultasi' => 'badge-info',
            'Tidak Ada' => 'badge-error',
            default => 'badge-ghost',
        };
    }

    // Get status emoji
    public function getStatusEmojiAttribute()
    {
        if (!$this->status) return '⚪';
        
        return match($this->status->status) {
            'Ada' => '🟢',
            'Mengajar' => '🟡',
            'Konsultasi' => '🔵',
            'Tidak Ada' => '🔴',
            default => '⚪',
        };
    }
}
