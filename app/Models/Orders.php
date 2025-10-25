<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    // Tên bảng
    protected $table = 'orders';

    // Các cột cho phép fill
    protected $fillable = [
        'ma_don_hang',
        'hinh_anh',
        'so_luong',
        'id_khach_hang',
        'id_voucher',
        'ten_nguoi_nhan',
        'so_dien_thoai',
        'tien_hang',
        'tong_tien',
        'is_thanh_toan',
        'tinh_trang',
    ];

    // Quan hệ với customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_khach_hang');
    }

    // Quan hệ với voucher
    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'id_voucher');
    }

    public function product()
{
    return $this->belongsTo(Products::class, 'id_san_pham');
}

}
