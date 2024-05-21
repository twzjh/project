<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'service_introduce',
        'service_price',
    ];

    public function cart()
    {
        return $this->hasMany(Cart::class, 'goods_id')->where('goods_type', 1);
    }

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class, 'goods_id')->where('goods_type', 1);
    }
}
