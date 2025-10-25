<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('reviews')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('reviews')->insert([
            // Product 1: Xiaomi Mi Vacuum
            [
                'product_id' => 1,
                'user_id' => 1,
                'rating' => 5,
                'comment' => 'Robot hút bụi cực kì tiện lợi, pin lâu.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'user_id' => 2,
                'rating' => 4,
                'comment' => 'Hài lòng, nhưng hơi ồn khi hoạt động.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 2: Ecovacs Deebot T9
            [
                'product_id' => 2,
                'user_id' => 1,
                'rating' => 5,
                'comment' => 'Tự giặt giẻ lau rất thông minh, đáng tiền!',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'product_id' => 2,
                'user_id' => 3,
                'rating' => 4,
                'comment' => 'Hút bụi tốt, app hơi khó dùng.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 3: iRobot Roomba i7+
            [
                'product_id' => 3,
                'user_id' => 2,
                'rating' => 5,
                'comment' => 'Dock tự động đổ rác quá tiện!',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'product_id' => 3,
                'user_id' => 4,
                'rating' => 4,
                'comment' => 'Sử dụng ổn nhưng giá cao.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 4: Dreame D9 Pro
            [
                'product_id' => 4,
                'user_id' => 1,
                'rating' => 5,
                'comment' => 'Cảm biến LDS + SLAM cực chuẩn, lau sạch.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 5: Roborock S7
            [
                'product_id' => 5,
                'user_id' => 3,
                'rating' => 4,
                'comment' => 'Lưu nhiều tầng tiện lợi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 6: Eufy RoboVac G30
            [
                'product_id' => 6,
                'user_id' => 2,
                'rating' => 5,
                'comment' => 'Nhỏ gọn nhưng lực hút mạnh, ok.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'product_id' => 6,
                'user_id' => 4,
                'rating' => 4,
                'comment' => 'Tuyệt vời cho căn phòng nhỏ.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 7: Philips SmartPro Easy
            [
                'product_id' => 7,
                'user_id' => 1,
                'rating' => 4,
                'comment' => 'Nhỏ gọn, nhiều chế độ làm sạch.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 8: Samsung Jet Bot AI+
            [
                'product_id' => 8,
                'user_id' => 3,
                'rating' => 5,
                'comment' => 'AI nhận diện vật thể rất thông minh.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 9: Panasonic Rulo MC-RS810
            [
                'product_id' => 9,
                'user_id' => 2,
                'rating' => 4,
                'comment' => 'Hình tam giác hút góc tốt.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 10: LG CordZero R9
            [
                'product_id' => 10,
                'user_id' => 1,
                'rating' => 5,
                'comment' => 'Camera 3D quét phòng chuẩn.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 11: Xiaomi Mijia M30S
            [
                'product_id' => 11,
                'user_id' => 3,
                'rating' => 4,
                'comment' => 'Lực hút tốt, tự sạc tiện lợi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Product 12: Ecovacs Winbot 950
            [
                'product_id' => 12,
                'user_id' => 2,
                'rating' => 5,
                'comment' => 'An toàn, chống rơi hiệu quả.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'user_id' => 3,
                'rating' => 4,
                'comment' => 'Robot tốt nhưng hơi ồn khi chạy carpet.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'user_id' => 4,
                'rating' => 5,
                'comment' => 'Rất thông minh, giặt giẻ lau sạch.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 5,
                'user_id' => 1,
                'rating' => 5,
                'comment' => 'Công nghệ lau rung Sonic Mopping tuyệt vời.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 8,
                'user_id' => 2,
                'rating' => 4,
                'comment' => 'Camera AI nhận diện vật thể khá chuẩn.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
