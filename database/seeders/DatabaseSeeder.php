<?php

namespace Database\Seeders;

use App\Models\AdminAccount;
use App\Models\Customer;
use App\Models\Products;
use App\Models\User;
use App\Models\Orders;
use App\Models\Voucher;
use App\Models\DanhMuc;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạm tắt kiểm tra ràng buộc khóa ngoại
        Schema::disableForeignKeyConstraints();
        $this->call([
            DanhMucSeeder::class,
            ProductsSeeder::class,
            CustomerSeeder::class,
            VoucherSeeder::class,
            OrdersSeeder::class,
            AdminAccountSeeder::class
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
