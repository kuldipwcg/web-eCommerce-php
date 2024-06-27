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
        Schema::create('product_images', function (Blueprint $table) {
            
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->uuid('product_image');
            $table->uuid('color_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
