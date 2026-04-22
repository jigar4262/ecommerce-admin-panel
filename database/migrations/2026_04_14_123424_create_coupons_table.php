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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code')->unique();
            $table->enum('discount_type',['flat','percentage']);
            $table->double('discount_value');
            $table->double('max_discount')->nullable();
            $table->double('min_order_amt')->default(0);
            $table->double('per_user_limit')->default(0);
            $table->double('total_usage_limit')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('is_login_required');
            $table->string('apply_coupon_on');
            $table->text('description')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('used_count')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
