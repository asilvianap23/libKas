<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kas extends Model
{
    use HasFactory;
    protected $fillable = ['amount', 'type', 'description', 'user_id', 'is_verified', 'bukti'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'rejected_at' => 'datetime',
        'verified_at' => 'datetime',
    ];
}
