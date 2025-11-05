<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $this->call([
            AdminAccountSeeder::class, // chỉ seed 1 admin chính
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
