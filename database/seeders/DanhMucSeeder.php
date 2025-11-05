<?php

namespace Database\Seeders;

<<<<<<< HEAD
=======
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
>>>>>>> 533f6d0ddad997d6e7f22d7b5dc3b8c89c757669
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhMucSeeder extends Seeder
{
    public function run(): void
    {
<<<<<<< HEAD
        DB::table('danh_mucs')->truncate();

        // Không seed dữ liệu ở đây
=======
        DB::table('danh_mucs')->delete();
        DB::table('danh_mucs')->truncate();
        DB::table('danh_mucs')->insert([
            [
                'images' => 'https://homebot.vn/wp-content/uploads/2021/07/ihil.jpg',
                'title'  => 'Robot hút bụi Ecovacs Deebot',
                'slug'   => 'robot-hut-bui-ecovacs',
                'price'  => 7200000,
                'quantity' => 20,
                'status' => 1,
            ],
            [
                'images' => 'https://techzhome.vn/media/product/585_mijia_m30s.jpg',
                'title'  => 'Robot lau nhà Xiaomi Mijia',
                'slug'   => 'robot-lau-nha-xiaomi',
                'price'  => 6900000,
                'quantity' => 15,
                'status' => 1,
            ],
            [
                'images' => 'https://dreametech.vn/wp-content/uploads/2022/09/miviet.com-robot-hut-bui-lau-nha-dreame-l10s-ultra-dreame-l10s-ultra.jpg',
                'title'  => 'Robot hút bụi lau nhà Dreame',
                'slug'   => 'robot-hut-bui-lau-nha-dreame',
                'price'  => 8500000,
                'quantity' => 18,
                'status' => 1,
            ],
            [
                'images' => 'https://vietnamrobotics.vn/wp-content/uploads/2018/03/Ecovacs-Winbot-950-01.webp',
                'title'  => 'Robot lau kính Hoover HL5000',
                'slug'   => 'robot-lau-kinh-hoover',
                'price'  => 200000,
                'quantity' => 10,
                'status' => 1,
            ],
            [
                'images' => 'https://product.hstatic.net/200000574527/product/roborock-s7-maxv-ultra-3_563ff5c10127414d8d94abd64aab1ff8_1024x1024.jpg',
                'title'  => 'Robot hút bụi Roborock S7 MaxV',
                'slug'   => 'robot-hut-bui-roborock-s7-maxv',
                'price'  => 15900000,
                'quantity' => 8,
                'status' => 1,
            ],
            [
                'title' => 'Robot hút bụi Samsung Jet Bot AI+',
                'slug' => 'robot-hut-bui-samsung-jet-bot-ai-plus',
                'images' => 'https://vcdn1-sohoa.vnecdn.net/2024/12/19/Picture2-6831-1734608541.jpg?w=460&h=0&q=100&dpr=2&fit=crop&s=xbrxPz_qlOZGf8YIOkk23g',
                'price' => 19990000,
                'quantity' =>4,
                'status' => 1,
            ],
            [
                'title' => 'Robot hút bụi Philips SmartPro Easy',
                'slug' => 'robot-hut-bui-philips-smartpro-easy',
                'images' => 'https://bigshop.vn/media/product/250_2536_robot_hut_bui_thong_minh_philips_fc8776_700.jpg',
                'price' => 4990000,
                'quantity' => 9,
                'status' => 1,
            ],
            [
                'title' => 'Robot hút bụi Eufy RoboVac G30',
                'slug' => 'robot-hut-bui-eufy-robovac-g30',
                'images' => 'https://nvs.tn-cdn.net/2022/05/Eufy-RoboVac-G30-Hybrid-6.jpg',
                'price' => 5990000,
                'quantity' => 12,
                'status' => 1,
            ],

        ]);
>>>>>>> 533f6d0ddad997d6e7f22d7b5dc3b8c89c757669
    }
}
