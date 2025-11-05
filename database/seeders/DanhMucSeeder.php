<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhMucSeeder extends Seeder
{
    public function run(): void
    {

        DB::table('danh_mucs')->truncate();

        // Không seed dữ liệu ở đây
    }
}
