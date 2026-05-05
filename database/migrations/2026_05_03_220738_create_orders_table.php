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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no', 50)->unique();
            $table->float('total_price')->nullable();
            $table->float('sub_total')->nullable();
            $table->double('tax')->nullable();
            $table->double('shipping')->nullable();
            $table->tinyInteger('payment_status')->default(2)->comment('1=paid, 2=pending, 3=unpaid');
            $table->tinyInteger('payment_method')->default(0)->comment('0=cash, 1=online');
            $table->smallInteger('tracking')->default(1)->comment('1=Ordered, 2=Pending, 3=Accept, 4=Delivery, 5=Received');
            $table->string('building', 50)->nullable();
            $table->string('apartment', 50)->nullable();
            $table->string('floor', 50)->nullable();
            $table->text('address')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
