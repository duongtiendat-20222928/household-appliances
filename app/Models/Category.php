<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['parent_id', 'name', 'slug', 'status'];

    // Khai báo: 1 Danh mục có nhiều Sản phẩm
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
