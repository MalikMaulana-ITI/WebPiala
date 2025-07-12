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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id('invoice_id'); // Primary key for invoices table
            $table->unsignedBigInteger('order_id')->unique(); // Foreign key to orders table, unique as one order has one invoice
            $table->string('invoice_number')->unique(); // Unique invoice number
            $table->decimal('amount', 10, 2); // Total amount of the invoice
            $table->string('payment_status')->default('pending'); // e.g., 'pending', 'paid', 'failed', 'expired'
            $table->string('midtrans_transaction_id')->nullable(); // Midtrans transaction ID
            $table->string('midtrans_snap_token')->nullable(); // Midtrans Snap Token
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};