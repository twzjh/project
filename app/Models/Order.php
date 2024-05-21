<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_status',
        'total',
        'remittance_date',
        'remittance_price',
        'last_number',
    ];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function permission()
    {
        return $this->hasMany(Permission::class);
    }
}
