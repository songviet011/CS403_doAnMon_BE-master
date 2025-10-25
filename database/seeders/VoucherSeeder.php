<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Schema::disableForeignKeyConstraints();
        DB::table('vouchers')->truncate();   // hoặc delete()
        Schema::enableForeignKeyConstraints();
        DB::table('vouchers')->insert([
            [
                'id' => 1,
                'ma_code' => 'SAVE10',
                'thoi_gian_bat_dau' => '2025-05-01',
                'thoi_gian_ket_thuc' => '2025-06-01',
                'loai_giam' => 1,
                'so_giam_gia' => 10,
                'so_tien_toi_da' => 30000,
                'don_hang_toi_thieu' => 100000,
                'tinh_trang' => 1,
                'id_san_pham' => 5,
                'hinh_anh' => 'https://thuvienmuasam.com/uploads/default/original/2X/e/eb5195361a1c0e308b3acf2426984e87fb5f8cb7.jpeg',
                'ten_voucher' => 'Giảm 10% cho đơn từ 100k'
            ],
            [
                'id' => 2,
                'ma_code' => 'FREESHIP50',
                'thoi_gian_bat_dau' => '2025-05-01',
                'thoi_gian_ket_thuc' => '2025-06-30',
                'loai_giam' => 0,
                'so_giam_gia' => 20000,
                'so_tien_toi_da' => 20000,
                'don_hang_toi_thieu' => 50000,
                'tinh_trang' => 1,
                'id_san_pham' => 11,
                'hinh_anh' => 'https://thuvienmuasam.com/uploads/default/original/2X/e/eb5195361a1c0e308b3acf2426984e87fb5f8cb7.jpeg',
                'ten_voucher' => 'Miễn phí vận chuyển đơn từ 50k'
            ],
            [
                'id' => 3,
                'ma_code' => 'WELCOME20',
                'thoi_gian_bat_dau' => '2025-05-05',
                'thoi_gian_ket_thuc' => '2025-07-05',
                'loai_giam' => 1,
                'so_giam_gia' => 20,
                'so_tien_toi_da' => 40000,
                'don_hang_toi_thieu' => 80000,
                'tinh_trang' => 1,
                'id_san_pham' => 2,
                'hinh_anh' => 'https://thuvienmuasam.com/uploads/default/original/2X/e/eb5195361a1c0e308b3acf2426984e87fb5f8cb7.jpeg',
                'ten_voucher' => 'Chào mừng khách mới - giảm 20%'
            ],
            [
                'id' => 4,
                'ma_code' => 'FLASHSALE30',
                'thoi_gian_bat_dau' => '2025-05-10',
                'thoi_gian_ket_thuc' => '2025-05-15',
                'loai_giam' => 1,
                'so_giam_gia' => 30,
                'so_tien_toi_da' => 50000,
                'don_hang_toi_thieu' => 70000,
                'tinh_trang' => 1,
                'id_san_pham' => 17,
                'hinh_anh' => 'https://thuvienmuasam.com/uploads/default/original/2X/e/eb5195361a1c0e308b3acf2426984e87fb5f8cb7.jpeg',
                'ten_voucher' => 'Flash Sale 30% - Chỉ 5 ngày'
            ],
            [
                'id' => 5,
                'ma_code' => 'SUMMER15',
                'thoi_gian_bat_dau' => '2025-06-01',
                'thoi_gian_ket_thuc' => '2025-07-15',
                'loai_giam' => 1,
                'so_giam_gia' => 15,
                'so_tien_toi_da' => 35000,
                'don_hang_toi_thieu' => 60000,
                'tinh_trang' => 1,
                'id_san_pham' => 8,
                'hinh_anh' => 'https://thuvienmuasam.com/uploads/default/original/2X/e/eb5195361a1c0e308b3acf2426984e87fb5f8cb7.jpeg',
                'ten_voucher' => 'Ưu đãi mùa hè 15%'
            ],
        ]);
    }
}
