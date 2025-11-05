<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('customers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Không seed dữ liệu ở đây

    }
}
