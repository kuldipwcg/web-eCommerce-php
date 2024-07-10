<?php

use Carbon\Carbon;
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
            $table->unsignedBigInteger('user_id');
            $table->datetime('order_date')->default(Carbon::now());
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered'])->default('pending');
            $table->double('total', 6, 2);
            $table->timestamps();
            
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
