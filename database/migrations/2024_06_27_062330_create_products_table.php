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
         Schema::create('products', function (Blueprint $table) {
             $table->id();
             $table->string('product_name',32);
             $table->text('short_desc');
             $table->text('description');
             $table->text('information');
             $table->double('price',6,2);
             $table->unsignedBigInteger('category_id');
             $table->enum('discount_type', ['fixed', 'percentage']);
             $table->integer('discount_value');
             $table->enum('is_featured', ['true', 'false'])->default('false');
             $table->timestamps();
         });
     }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
