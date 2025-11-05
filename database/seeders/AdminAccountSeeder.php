<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\Hash;
>>>>>>> 533f6d0ddad997d6e7f22d7b5dc3b8c89c757669

class AdminAccountSeeder extends Seeder
{
    public function run(): void
    {
<<<<<<< HEAD
        // Xóa sạch dữ liệu cũ
        DB::table('admin_accounts')->truncate();

        // Tạo 1 tài khoản admin chính (mật khẩu dạng gốc)
=======
        // Xóa dữ liệu cũ (nếu có)
        DB::table('admin_accounts')->truncate();

        // Thêm dữ liệu mẫu
>>>>>>> 533f6d0ddad997d6e7f22d7b5dc3b8c89c757669
        DB::table('admin_accounts')->insert([
            [
                'email' => 'admin@master.com',
                'ho_va_ten' => 'Admin Master',
<<<<<<< HEAD
                'password' => '123456', // ❗ Không mã hóa
                'so_dien_thoai' => '0901234567',
                'dia_chi' => '180 Cao Lỗ, Phường 4, Quận 8, TP.HCM',
                'ngay_sinh' => '1990-01-15',
                'created_at' => now(),
                'updated_at' => now(),
=======
                'password' => '123456',
                'so_dien_thoai' => '0901234567',
                'dia_chi' => '180 Cao Lỗ, Phường 4, Quận 8, TP.HCM',
                'ngay_sinh' => '1990-01-15',
            ],
            [
                'email' => 'giamdoc@gmail.com',
                'ho_va_ten' => 'Nguyễn Văn Giám',
                'password' => '123456',
                'so_dien_thoai' => '0912345678',
                'dia_chi' => '123 Nguyễn Văn Cừ, Quận 5, TP.HCM',
                'ngay_sinh' => '1985-03-20',
            ],
            [
                'email' => 'nhansu@gmail.com',
                'ho_va_ten' => 'Trần Thị Nhân',
                'password' => '123456',
                'so_dien_thoai' => '0923456789',
                'dia_chi' => '456 Lý Thường Kiệt, Quận 10, TP.HCM',
                'ngay_sinh' => '1988-07-25',
            ],
            [
                'email' => 'ketoan@gmail.com',
                'ho_va_ten' => 'Lê Thị Kế',
                'password' => '123456',
                'so_dien_thoai' => '0934567890',
                'dia_chi' => '789 Cách Mạng Tháng 8, Quận 3, TP.HCM',
                'ngay_sinh' => '1992-12-10',
            ],
            [
                'email' => 'it@gmail.com',
                'ho_va_ten' => 'Phạm Văn Công Nghệ',
                'password' => '123456',
                'so_dien_thoai' => '0945678901',
                'dia_chi' => '321 Võ Văn Ngân, TP.Thủ Đức, TP.HCM',
                'ngay_sinh' => '1994-05-05',
>>>>>>> 533f6d0ddad997d6e7f22d7b5dc3b8c89c757669
            ],
        ]);
    }
}
