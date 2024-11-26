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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Billing Information
            $table->string('billing_email')->nullable();
            $table->string('billing_name')->nullable();
            $table->string('billing_name_on_card')->nullable();
            $table->string('billing_address');
            $table->string('billing_city')->nullable();
            $table->string('billing_apartment')->nullable();
            $table->string('billing_zip_code')->nullable();
            $table->unsignedInteger('billing_subtotal');
            $table->unsignedInteger('billing_tax');
            $table->unsignedInteger('billing_total');

            // Shipping Information
            $table->boolean('pick_up_at_warehouse')->default('false');
            $table->boolean('shipped')->default(false);

            // Crypto Transaction Information
            $table->string('payment_method')->default('fiat');
            $table->string('crypto_type')->nullable();
            $table->string('crypto_address')->nullable();
            $table->decimal('crypto_amount', 20, 8)->nullable();
            $table->string('crypto_transaction_id')->nullable();
            $table->decimal('fiat_equivalent', 15, 2)->nullable();

            // Timestamps
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
