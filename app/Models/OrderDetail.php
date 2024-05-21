<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'goods_id',
        'goods_type',
        'goods_price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'goods_id');
    }

    public function course()
    {
        return $this->hasOne(Course::class, 'id', 'goods_id');
    }
}
