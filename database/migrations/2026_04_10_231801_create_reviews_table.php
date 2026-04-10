<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // ID sản phẩm
            $table->foreignId('user_id')->constrained()->onDelete('cascade');    // ID người dùng (ai đánh giá)
            $table->integer('rating')->default(5); // Số sao (1 đến 5)
            $table->text('comment');               // Nội dung bình luận
            $table->boolean('is_approved')->default(true); // Trạng thái duyệt bình luận
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
