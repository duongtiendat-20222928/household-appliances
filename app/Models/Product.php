<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes; // Cho phép chức năng thùng rác (không xóa hẳn khỏi DB)

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'specifications',
        'warranty_months',
        'status'
    ];

    // Cực kỳ quan trọng: Ép kiểu cột JSON thành Array
    protected $casts = [
        'specifications' => 'array',
    ];

    // Khai báo: 1 Sản phẩm thuộc về 1 Danh mục
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Khai báo: 1 Sản phẩm có nhiều Biến thể (SKU/Màu sắc)
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
