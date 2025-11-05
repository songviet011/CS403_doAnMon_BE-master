<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminAccountSeeder extends Seeder
{
    public function run(): void
    {
        // Xóa sạch dữ liệu cũ
        DB::table('admin_accounts')->truncate();

        // Tạo 1 tài khoản admin chính (mật khẩu dạng gốc)
        DB::table('admin_accounts')->insert([
            [
                'email' => 'admin@master.com',
                'ho_va_ten' => 'Admin Master',
                'password' => '123456', // ❗ Không mã hóa
                'so_dien_thoai' => '0901234567',
                'dia_chi' => '180 Cao Lỗ, Phường 4, Quận 8, TP.HCM',
                'ngay_sinh' => '1990-01-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
