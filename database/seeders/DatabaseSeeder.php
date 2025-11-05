<?php

namespace Database\Seeders;

<<<<<<< HEAD
use Illuminate\Database\Seeder;
=======
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
>>>>>>> 533f6d0ddad997d6e7f22d7b5dc3b8c89c757669
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
<<<<<<< HEAD
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $this->call([
            AdminAccountSeeder::class, // chỉ seed 1 admin chính
        ]);

=======
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
>>>>>>> 533f6d0ddad997d6e7f22d7b5dc3b8c89c757669
        Schema::enableForeignKeyConstraints();
    }
}
