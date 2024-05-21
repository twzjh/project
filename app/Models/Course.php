<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'course_type',
        'course_price',
        'course_introduce',
        'detail_introduce',
        'course_image',
        'course_hour',
        'course_main',
    ];

    public function cart()
    {
        return $this->hasMany(Cart::class, 'goods_id')->where('goods_type', 2);
    }

    public function chapter()
    {
        return $this->hasMany(Chapter::class, 'course_id');
    }

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class, 'goods_id')->where('goods_type', 2);
    }
    public function permission()
    {
        return $this->hasMany(Permission::class, 'course_id');
    }
}
