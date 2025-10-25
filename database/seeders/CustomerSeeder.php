<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
         DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('customers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('customers')->insert([
                [
                    'email'             => 'nbinh3120@gmail.com',
                    'password'          =>  '123456',
                    'ho_va_ten'         => 'Nguyễn Diệp Thanh Bình',
                    'so_dien_thoai'     => '0987654321',
                    'dia_chi'           => 'Đà Nẵng',
                    'ngay_sinh'         => '1994-02-14',
                ],
                [
                    'email'             => 'phamthikieu@gmail.com',
                    'password'          => '123456',
                    'ho_va_ten'         => 'Phạm Thị Kiều',
                    'so_dien_thoai'     => '0911223344',
                    'dia_chi'           => 'Nha Trang',
                    'ngay_sinh'         => '1999-07-19',
                ],
                [
                    'email'             => 'tranductuan@gmail.com',
                    'password'          => '123456',
                    'ho_va_ten'         => 'Trần Đức Tuấn',
                    'so_dien_thoai'     => '0909887766',
                    'dia_chi'           => 'Vũng Tàu',
                    'ngay_sinh'         => '1993-12-05',
                ],
                [
                    'email'             => 'lethuyduong@gmail.com',
                    'password'          => '123456',
                    'ho_va_ten'         => 'Lê Thúy Dương',
                    'so_dien_thoai'     => '0933445566',
                    'dia_chi'           => 'Quảng Ninh',
                    'ngay_sinh'         => '2001-09-21',
                ],
                [
                    'email'             => 'dangvanhieu@gmail.com',
                    'password'          => '123456',
                    'ho_va_ten'         => 'Đặng Văn Hiếu',
                    'so_dien_thoai'     => '0966554433',
                    'dia_chi'           => 'Biên Hòa',
                    'ngay_sinh'         => '1992-06-11',
                ],
            ]


        );
    }
}
