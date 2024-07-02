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
        Schema::create('pivot_size', function (Blueprint $table) {
            $table->uuid('product_id');
            $table->uuid('size_id');
            $table->timestamps();
            
    //         $table->foreign('product_id')->references('id')
    //         ->on('products')->onDelete('cascade');
    //    $table->foreign('size_id')->references('id')
    //         ->on('product_sizes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
