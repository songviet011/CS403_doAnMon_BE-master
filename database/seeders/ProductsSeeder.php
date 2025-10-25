<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('products')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('products')->insert([
            [
                'title' => 'Robot hút bụi Xiaomi Mi Vacuum',
                'slug' => 'robot-hut-bui-xiaomi-mi-vacuum',
                'images' => 'https://product.hstatic.net/200000574527/product/robot-hut-bui-xiaomi-mi-robot-vacuum-mop-2-eu-bhr5055eu-g_8f90c2e7919243cf8c5564024c280673.jpg',
                'price' => 5000,
                'quantity' => 15,
                'brand' => 'Xiaomi',
                'description' => 'Robot hút bụi thông minh, điều khiển qua app Mi Home.',
                'specs' => json_encode([
                    'pin' => '5200mAh',
                    'cong_suat' => '2000Pa',
                    'thoi_gian_sac' => '4h',
                    'ketnoi' => 'WiFi + App',
                    'tinh_nang' => 'Điều khiển qua app'
                ]),
                'warranty' => 12,
                'status' => 'active',
            ],
            [
                'title' => 'Robot hút bụi Ecovacs Deebot T9',
                'slug' => 'robot-hut-bui-ecovacs-deebot-t9',
                'images' => 'https://digihouse.vn/wp-content/uploads/2021/12/t9-aivi-1.png',
                'price' => 8990000,
                'quantity' => 8,
                'brand' => 'Ecovacs',
                'description' => 'Robot hút bụi cao cấp, có khả năng tự giặt giẻ lau.',
                'specs' => json_encode([
                    'pin' => '5200mAh',
                    'cong_suat' => '3000Pa',
                    'thoi_gian_sac' => '5h',
                    'ketnoi' => 'WiFi + App',
                    'tinh_nang' => 'Tự động đổ rác'
                ]),
                'warranty' => 24,
                'status' => 'active',
            ],
            [
                'title' => 'Robot hút bụi iRobot Roomba i7+',
                'slug' => 'robot-hut-bui-irobot-roomba-i7-plus',
                'images' => 'https://irobot.vn/wp-content/uploads/2021/01/irobot-roomba-i7-plus.jpg',
                'price' => 15990000,
                'quantity' => 5,
                'brand' => 'iRobot',
                'description' => 'Robot hút bụi Mỹ, bản cao cấp có dock tự đổ rác.',
                'specs' => json_encode([
                    'pin' => '3300mAh',
                    'cong_suat' => '2500Pa',
                    'thoi_gian_sac' => '3.5h',
                    'ketnoi' => 'WiFi + App + Voice',
                    'tinh_nang' => 'Dock tự động đổ rác'
                ]),
                'warranty' => 24,
                'status' => 'active',
            ],
            [
                'title' => 'Robot hút bụi Dreame D9 Pro',
                'slug' => 'robot-hut-bui-dreame-d9-pro',
                'images' => 'https://ihomestore.vn/wp-content/uploads/2022/09/robot-hut-bui-dreame-d9-pro-3.jpg',
                'price' => 7990000,
                'quantity' => 10,
                'brand' => 'Dreame',
                'description' => 'Robot hút bụi lau nhà mạnh mẽ, cảm biến LDS.',
                'specs' => json_encode([
                    'pin' => '5200mAh',
                    'cong_suat' => '4000Pa',
                    'thoi_gian_sac' => '5h',
                    'ketnoi' => 'WiFi + App',
                    'tinh_nang' => 'Cảm biến LDS + SLAM'
                ]),
                'warranty' => 18,
                'status' => 'active',
            ],
            [
                'title' => 'Robot hút bụi Roborock S7',
                'slug' => 'robot-hut-bui-roborock-s7',
                'images' => 'https://mivietnam.vn/wp-content/uploads/2022/05/mivietnam-robot-hut-bui-roborock-s7-maxv-ultra-cover-00.jpg',
                'price' => 12990000,
                'quantity' => 6,
                'brand' => 'Roborock',
                'description' => 'Robot hút bụi cao cấp, công nghệ lau rung Sonic Mopping.',
                'specs' => json_encode([
                    'pin' => '5200mAh',
                    'cong_suat' => '2500Pa',
                    'thoi_gian_sac' => '4.5h',
                    'ketnoi' => 'WiFi + App + Voice',
                    'tinh_nang' => 'Lưu nhiều tầng'
                ]),
                'warranty' => 24,
                'status' => 'active',
            ],
            [
                'title' => 'Robot hút bụi Eufy RoboVac G30',
                'slug' => 'robot-hut-bui-eufy-robovac-g30',
                'images' => 'https://nvs.tn-cdn.net/2022/05/Eufy-RoboVac-G30-Hybrid-6.jpg',
                'price' => 5990000,
                'quantity' => 12,
                'brand' => 'Eufy',
                'description' => 'Robot hút bụi nhỏ gọn, lực hút mạnh, điều khiển qua app.',
                'specs' => json_encode([
                    'pin' => '2600mAh',
                    'cong_suat' => '2000Pa',
                    'thoi_gian_sac' => '3h',
                    'ketnoi' => 'WiFi + App',
                    'tinh_nang' => 'Nhỏ gọn, lực hút mạnh'
                ]),
                'warranty' => 12,
                'status' => 'active',
            ],
            [
                'title' => 'Robot hút bụi Philips SmartPro Easy',
                'slug' => 'robot-hut-bui-philips-smartpro-easy',
                'images' => 'https://bigshop.vn/media/product/250_2536_robot_hut_bui_thong_minh_philips_fc8776_700.jpg',
                'price' => 4990000,
                'quantity' => 9,
                'brand' => 'Philips',
                'description' => 'Robot hút bụi thiết kế gọn nhẹ, nhiều chế độ làm sạch.',
                'specs' => json_encode([
                    'pin' => '2600mAh',
                    'cong_suat' => '1500Pa',
                    'thoi_gian_sac' => '3h',
                    'ketnoi' => 'Remote',
                    'tinh_nang' => 'Gọn nhẹ, nhiều chế độ'
                ]),
                'warranty' => 12,
                'status' => 'active',
            ],
            [
                'title' => 'Robot hút bụi Samsung Jet Bot AI+',
                'slug' => 'robot-hut-bui-samsung-jet-bot-ai-plus',
                'images' => 'https://vcdn1-sohoa.vnecdn.net/2024/12/19/Picture2-6831-1734608541.jpg?w=460&h=0&q=100&dpr=2&fit=crop&s=xbrxPz_qlOZGf8YIOkk23g',
                'price' => 19990000,
                'quantity' => 4,
                'brand' => 'Samsung',
                'description' => 'Robot hút bụi AI, tự động đổ rác, camera thông minh.',
                'specs' => json_encode([
                    'pin' => '5000mAh',
                    'cong_suat' => '4000Pa',
                    'thoi_gian_sac' => '5h',
                    'ketnoi' => 'WiFi + App + Voice',
                    'tinh_nang' => 'AI Object Recognition'
                ]),
                'warranty' => 24,
                'status' => 'active',
            ],
            [
                'title' => 'Robot hút bụi Panasonic Rulo MC-RS810',
                'slug' => 'robot-hut-bui-panasonic-rulo-mc-rs810',
                'images' => 'https://robotnoidianhat.com/wp-content/uploads/2021/05/810-3.jpg',
                'price' => 13990000,
                'quantity' => 3,
                'brand' => 'Panasonic',
                'description' => 'Robot hút bụi hình tam giác độc đáo, dễ dàng làm sạch góc.',
                'specs' => json_encode([
                    'pin' => '3200mAh',
                    'cong_suat' => '2000Pa',
                    'thoi_gian_sac' => '4h',
                    'ketnoi' => 'WiFi + App',
                    'tinh_nang' => 'Hình tam giác, dễ làm sạch góc'
                ]),
                'warranty' => 18,
                'status' => 'active',
            ],
            [
                'title' => 'Robot hút bụi LG CordZero R9',
                'slug' => 'robot-hut-bui-lg-cordzero-r9',
                'images' => 'https://robothutbui.vn/wp-content/uploads/2020/03/LG_CordZero_R9MASTER_B01.jpg',
                'price' => 17990000,
                'quantity' => 5,
                'brand' => 'LG',
                'description' => 'Robot hút bụi cao cấp của LG, camera 3D thông minh.',
                'specs' => json_encode([
                    'pin' => '4000mAh',
                    'cong_suat' => '2800Pa',
                    'thoi_gian_sac' => '5h',
                    'ketnoi' => 'WiFi + App + Voice',
                    'tinh_nang' => 'Camera 3D'
                ]),
                'warranty' => 24,
                'status' => 'active',
            ],
            [
                'title' => 'Robot lau nhà Xiaomi Mijia M30S',
                'slug' => 'robot-lau-nha-xiaomi-m30s',
                'images' => 'https://techzhome.vn/media/product/585_mijia_m30s.jpg',
                'price' => 6900000,
                'quantity' => 15,
                'brand' => 'Xiaomi',
                'description' => 'Robot lau nhà thông minh Xiaomi Mijia M30S, lực hút mạnh, hỗ trợ điều khiển qua app Mi Home.',
                'specs' => json_encode([
                    'pin' => '3200mAh',
                    'cong_suat' => '2500Pa',
                    'thoi_gian_sac' => '4h',
                    'ketnoi' => 'WiFi + App',
                    'tinh_nang' => 'Tự động sạc, lau & hút cùng lúc'
                ]),
                'warranty' => 12,
                'status' => 'active',
            ],
            [
                'title' => 'Robot lau kính Ecovacs Winbot 950',
                'slug' => 'robot-lau-kinh-ecovacs-winbot-950',
                'images' => 'https://vietnamrobotics.vn/wp-content/uploads/2018/03/Ecovacs-Winbot-950-01.webp',
                'price' => 5200000,
                'quantity' => 10,
                'brand' => 'Ecovacs',
                'description' => 'Robot lau kính Ecovacs Winbot 950, tự động lau cửa sổ, an toàn với hệ thống cảm biến.',
                'specs' => json_encode([
                    'pin' => '2200mAh',
                    'cong_suat' => 'Không áp dụng',
                    'thoi_gian_sac' => 'N/A',
                    'ketnoi' => 'Tự động + Remote',
                    'tinh_nang' => 'Cảm biến an toàn, chống rơi'
                ]),
                'warranty' => 24,
                'status' => 'active',
            ],

        ]);
    }
}
