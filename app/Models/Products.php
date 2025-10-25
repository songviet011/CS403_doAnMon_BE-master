<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'title',        // tên sản phẩm
        'slug',         // đường dẫn SEO
        'images',       // lưu link ảnh hoặc JSON nhiều ảnh
        'price',        // giá
        'quantity',     // số lượng tồn kho
        'brand',        // thương hiệu
        'description',  // mô tả chi tiết
        'specs',        // thông số kỹ thuật
        'warranty',     // bảo hành (tháng)
        'status',       // tình trạng (active, inactive, out_of_stock)
    ];
    public function reviews()
{
    return $this->hasMany(Review::class, 'product_id', 'id');
}
}
