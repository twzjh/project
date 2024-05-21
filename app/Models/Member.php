<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'member_status',
        'member_phone',
        'member_birthday',
        'member_birth_time',
        'member_city',
        'member_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
