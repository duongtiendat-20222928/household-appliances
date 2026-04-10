<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id', 'rating', 'comment', 'is_approved'];

    // Một đánh giá thuộc về 1 người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Một đánh giá thuộc về 1 sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
