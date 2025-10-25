<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('order_items')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('order_items')->insert([
            [
                'order_id' => 1,
                'product_id' => 1, // id sản phẩm trong đơn DH001
                'quantity' => 1,
                'price' => 35000,
                'subtotal' => 35000,
                'created_at' => '2025-02-19 10:34:00',
                'updated_at' => '2025-02-19 10:34:00',
            ],
            [
                'order_id' => 2,
                'product_id' => 2, // id sản phẩm trong đơn DH002
                'quantity' => 1,
                'price' => 25000,
                'subtotal' => 25000,
                'created_at' => '2025-02-20 14:00:00',
                'updated_at' => '2025-02-20 14:00:00',
            ],
            [
                'order_id' => 3,
                'product_id' => 3,
                'quantity' => 1,
                'price' => 55000,
                'subtotal' => 55000,
                'created_at' => '2025-02-22 11:45:00',
                'updated_at' => '2025-02-22 11:45:00',
            ],
            [
                'order_id' => 4,
                'product_id' => 1,
                'quantity' => 1,
                'price' => 30000,
                'subtotal' => 30000,
                'created_at' => '2025-03-01 13:22:00',
                'updated_at' => '2025-03-01 13:22:00',
            ],
            [
                'order_id' => 5,
                'product_id' => 3,
                'quantity' => 1,
                'price' => 45000,
                'subtotal' => 45000,
                'created_at' => '2025-03-05 15:30:00',
                'updated_at' => '2025-03-05 15:30:00',
            ],
            [
                'order_id' => 6,
                'product_id' => 2,
                'quantity' => 1,
                'price' => 50000,
                'subtotal' => 50000,
                'created_at' => '2025-03-10 10:15:00',
                'updated_at' => '2025-03-10 10:15:00',
            ],
            [
                'order_id' => 7,
                'product_id' => 2,
                'quantity' => 1,
                'price' => 25000,
                'subtotal' => 25000,
                'created_at' => '2025-03-15 11:45:00',
                'updated_at' => '2025-03-15 11:45:00',
            ],
            [
                'order_id' => 8,
                'product_id' => 1,
                'quantity' => 2,
                'price' => 40000,
                'subtotal' => 80000,
                'created_at' => '2025-03-20 16:00:00',
                'updated_at' => '2025-03-20 16:00:00',
            ],
            [
                'order_id' => 9,
                'product_id' => 2,
                'quantity' => 1,
                'price' => 30000,
                'subtotal' => 30000,
                'created_at' => '2025-03-25 09:30:00',
                'updated_at' => '2025-03-25 09:30:00',
            ],
            [
                'order_id' => 10,
                'product_id' => 3,
                'quantity' => 1,
                'price' => 45000,
                'subtotal' => 45000,
                'created_at' => '2025-04-01 14:15:00',
                'updated_at' => '2025-04-01 14:15:00',
            ],
        ]);
}
}
