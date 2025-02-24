<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'chapter_name',
        'chapter_number',
        'chapter_introduce',
        'chapter_video',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
