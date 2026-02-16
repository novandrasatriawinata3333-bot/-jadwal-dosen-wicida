<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'status',
        'updated_at_iot',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'updated_at_iot' => 'datetime',
        ];
    }

    /**
     * RELATIONSHIPS
     */
    
    // Status belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * SCOPES
     */
    
    // Get only "Ada" status
    public function scopeAda($query)
    {
        return $query->where('status', 'Ada');
    }

    // Get only "Tidak Ada" status
    public function scopeTidakAda($query)
    {
        return $query->where('status', 'Tidak Ada');
    }

    /**
     * ACCESSORS
     */
    
    // Get badge color for DaisyUI
    public function getBadgeColorAttribute()
    {
        return match($this->status) {
            'Ada' => 'badge-success',
            'Mengajar' => 'badge-warning',
            'Konsultasi' => 'badge-info',
            'Tidak Ada' => 'badge-error',
            default => 'badge-ghost',
        };
    }

    // Get emoji representation
    public function getEmojiAttribute()
    {
        return match($this->status) {
            'Ada' => '🟢',
            'Mengajar' => '🟡',
            'Konsultasi' => '🔵',
            'Tidak Ada' => '🔴',
            default => '⚪',
        };
    }

    // Check if updated from IoT recently (within 5 minutes)
    public function getIsFromIotAttribute()
    {
        if (!$this->updated_at_iot) return false;
        
        return $this->updated_at_iot->diffInMinutes(now()) <= 5;
    }
}
