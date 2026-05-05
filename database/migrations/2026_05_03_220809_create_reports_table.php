<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            // Financial snapshots from your SQL
            $table->double('orders_amount')->nullable()->default(0);
            $table->integer('orders_count')->nullable()->default(0);
            $table->double('purchases_amount')->nullable()->default(0);
            $table->integer('purchases_count')->nullable()->default(0);
            $table->timestamps();
        });

        // product_order pivot
        Schema::create('product_order', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->float('price');
            $table->tinyInteger('return_status')->default(0)->comment('0=unreturn, 1=return');
            $table->primary(['product_id', 'order_id']);
        });

        // product_purchase pivot
        Schema::create('product_purchase', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('purchase_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->float('price');
            $table->tinyInteger('return_status')->default(0);
            $table->primary(['product_id', 'purchase_id']);
        });

        // product_user (wishlist/cart)
        Schema::create('product_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->primary(['product_id', 'user_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
        Schema::dropIfExists('product_order');
        Schema::dropIfExists('product_purchase');
        Schema::dropIfExists('product_user');
    }
};