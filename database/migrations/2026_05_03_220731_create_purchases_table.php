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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            $table->string('invoice_no', 50)->unique();
            $table->double('total_price')->nullable();
            $table->double('amount_paid')->default(0);
            $table->tinyInteger('payment_type')->default(1)->comment('1=new, 2=return');
            $table->tinyInteger('payment_status')->default(1)->comment('1=unpaid, 2=partially_paid, 3=paid');
            $table->boolean('active')->default(false)->comment('0=not active, 1=active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
