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
            $table->text('description');
            $table->double('product_price',6,2);
            // $table->double('discounted_price',6,2);
            $table->text('information');
            $table->uuid('category_id');
<<<<<<< HEAD
<<<<<<< HEAD
            $table->uuid('discount_id');
            $table->boolean('is_featured')->default(0);
=======
=======
>>>>>>> 7363e18 (category,sub-category and cart api)
            $table->uuid('subCategory_id');
            $table->boolean('is_featured')->default(0)->change();
>>>>>>> 7363e18 (category,sub-category and cart api)
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
