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
        Schema::create('sub_categories', function (Blueprint $table) {
<<<<<<< HEAD
           $table->id();
            $table->uuid('categoryId');
            $table->uuid('productId');
            $table->string('categoryType',15);
            $table->string('image');
=======
            $table->id();
            $table->unsignedBigInteger('category_id');
            // $table->uuid('product_id');
            $table->string('category_name',15);
>>>>>>> 7363e18 (category,sub-category and cart api)
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
