<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Cho phép thêm dữ liệu hàng loạt vào các cột này
    protected $fillable = [
        'user_id',
        'receiver_name',
        'receiver_phone',
        'receiver_email',
        'shipping_address',
        'note',
        'payment_method',
        'total_amount',
        'status'
    ];

    // 1 Đơn hàng có nhiều Chi tiết đơn hàng
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
