<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nip',
        'photo',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function status()
    {
        return $this->hasOne(Status::class);
    }

    // Helpers
    public function isKepalaLab(): bool
    {
        return $this->role === 'kepala_lab';
    }

    public function isStaf(): bool
    {
        return $this->role === 'staf';
    }
}
