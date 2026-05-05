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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_no');
            $table->integer('order_transaction_no');
            $table->boolean('pending')->default(false)->comment('0=paid, 1=pending');
            $table->boolean('success')->default(false)->comment('0=failed, 1=success');
            $table->string('source_type', 50);
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
