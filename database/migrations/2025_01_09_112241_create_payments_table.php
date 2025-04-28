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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Foreign keys and user identification
            $table->unsignedBigInteger('user_id');

            // Action details
            $table->string('who_action');  // Who made the action (e.g., admin, user)
            $table->string('type_action');  // Type of action (e.g., deposit, withdrawal)

            // Payment details
            $table->decimal('amount', 10, 2);  // Payment amount
            $table->unsignedBigInteger('currency_id');  // Link to currencies table

            // Action date
            $table->date('action_date');  // Payment date

            // Payment method
            $table->enum('payment_method', ['credit_card', 'debit_card', 'paypal', 'bank_transfer', 'cash'])->nullable();

            // Transaction reference (optional)
            $table->string('transaction_no')->nullable();  // Store transaction ID (e.g., PayPal, Stripe)

            // Timestamps
            $table->timestamps();  // Created at and updated at
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
