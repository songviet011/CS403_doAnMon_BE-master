<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
     protected $table = 'vouchers';
    protected $fillable = [
        'ma_code',
        'thoi_gian_bat_dau',
        'thoi_gian_ket_thuc',
        'loai_giam',
        'id_san_pham',
        'so_giam_gia',
        'so_tien_toi_da',
        'don_hang_toi_thieu',
        'tinh_trang',
        'hinh_anh',
        'ten_voucher',
    ];
}
