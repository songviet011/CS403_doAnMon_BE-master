<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('ma_don_hang')->unique();
            $table->string('hinh_anh')->nullable();
            $table->integer('so_luong')->default(1);
            $table->foreignId('id_khach_hang')->constrained('customers')->onDelete('cascade');
            $table->foreignId('id_voucher')->nullable()->constrained('vouchers')->onDelete('set null');
            $table->string('ten_nguoi_nhan');
            $table->string('so_dien_thoai', 15);
            $table->decimal('tien_hang', 15, 2)->default(0);
            $table->decimal('tong_tien', 15, 2)->default(0);
            $table->boolean('is_thanh_toan')->default(false);
            $table->tinyInteger('tinh_trang')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
