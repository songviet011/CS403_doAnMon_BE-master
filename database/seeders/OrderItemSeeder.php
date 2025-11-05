<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrderItemSeeder extends Seeder
{

    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('order_items')->truncate();
        Schema::enableForeignKeyConstraints();

        // Không seed dữ liệu
    }
}
