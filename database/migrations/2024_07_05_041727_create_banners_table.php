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
        Schema::create('banners', function (Blueprint $table) {

           $table->id();
            $table->string('banner_image')->nullable(true);
            $table->string('banner_title',25);
            $table->string('banner_desc',100);
            $table->string('banner_link');
            $table->timestamps();
            
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
