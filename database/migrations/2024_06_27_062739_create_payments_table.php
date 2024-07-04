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
            $table->unsignedBigInteger('order_id');
            $table->enum('payment_method', ["paypal", "credit_card", "bank_transfer"]);
            $table->double('amount', 6, 2);
            $table->uuid('transaction_id');
            $table->enum('transaction_status', ['completed', 'failed']);
            $table->date('payment_Date');
            $table->timestamps();
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
