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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Transaction details
            $table->string('note')->nullable();
            $table->enum('transaction_type', ['sale', 'purchase', 'return', 'order','card','reject']);
            $table->unsignedBigInteger('office_id')->nullable();
            $table->string('transaction_number')->nullable();

            // Taxi and loan details
            $table->string('taxi_id')->nullable();
            $table->string('taxi_garawatawa')->nullable();
            $table->string('who_loan')->nullable();

            // Payment and financial details
            $table->string('payment_method')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('unpaid_amount', 10, 2)->default(0);
            $table->unsignedBigInteger('currency_id');
            $table->decimal('exchange_rate', 10, 4)->nullable();

            // Foreign keys for relationships
            $table->unsignedBigInteger('transaction_type_id');
            $table->date('transaction_date');
            $table->unsignedBigInteger('who_transaction')->nullable();
            $table->unsignedBigInteger('transaction_by')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('forwarded_by')->nullable();

            // Forwarding details
            $table->string('is_forwarded')->nullable();
            $table->string('forwarded_accept')->nullable();
            $table->timestamp('forwarded_at')->nullable();
            $table->timestamp('accept_forwarded_at')->nullable();
            $table->string('forwarded_note')->nullable();

            // Order details
            $table->string('order_status')->nullable();
            $table->string('order_note')->nullable();
            $table->timestamp('order_first_change_status_date')->nullable();

            // Timestamps
            $table->timestamps();
        });
    }

    // دیاریکردنی نرخی موادەکان کۆی گشتی مەسرەف دەبەشی نرخی کاڵا
    //  لێکدانەوەی کە ئایە پێویستمان بەوەیە کە مواد بکرێن

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
