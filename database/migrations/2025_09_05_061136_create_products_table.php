<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');                  // tên sản phẩm
            $table->string('slug')->unique();         // slug SEO
            $table->text('images')->nullable();     // ảnh
            $table->decimal('price', 12, 2);          // giá
            $table->integer('quantity')->default(0);  // số lượng tồn kho
            $table->string('brand')->nullable();      // thương hiệu
            $table->longText('description')->nullable();  // mô tả chi tiết
            $table->json('specs')->nullable();        // thông số kỹ thuật
            $table->integer('warranty')->default(12); // bảo hành mặc định 12 tháng
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
