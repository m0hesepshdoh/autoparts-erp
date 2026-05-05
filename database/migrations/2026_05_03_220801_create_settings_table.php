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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->default('Company Name');
            $table->text('address')->default('Company Address');
            $table->string('phone', 15)->default('0000000000');
            $table->integer('tax')->default(14);
            $table->integer('shipping')->default(0);
            $table->text('image')->default('default.png');
            $table->text('payment_url')->default('https://accept.paymob.com/api/');
            $table->text('payment_token');
            $table->text('payment_integration_id');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
