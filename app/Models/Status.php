<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'last_updated',
    ];

    protected $casts = [
        'last_updated' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
