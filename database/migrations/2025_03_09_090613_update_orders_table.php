<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Xóa khóa ngoại cũ trước khi thay đổi cột user_id
            DB::statement("ALTER TABLE orders DROP FOREIGN KEY FKel9kyl84ego2otj2accfd8mr7");

            // Chuyển user_id thành BIGINT UNSIGNED để khớp với users.id
            $table->unsignedBigInteger('user_id')->nullable()->change();

            // Thêm khóa ngoại mới
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Xóa khóa ngoại mới nếu rollback
            $table->dropForeign(['user_id']);

            // Khôi phục lại kiểu dữ liệu cũ (giả sử trước đó là INT)
            $table->integer('user_id')->nullable()->change();
        });
    }
};
