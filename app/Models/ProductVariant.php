<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'sale_price',
        'stock_quantity',
        'attribute_values'
    ];

    // Ép kiểu cột JSON lưu thuộc tính (màu sắc, kích cỡ) thành Array
    protected $casts = [
        'attribute_values' => 'array',
    ];

    // Khai báo: 1 Biến thể thuộc về 1 Sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
