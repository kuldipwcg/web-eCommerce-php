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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status',['active','inactive'])->before('created_at')->default('active');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->enum('status',['active','inactive'])->default('active');
        });
       
        Schema::table('product_colors', function (Blueprint $table) {
            $table->enum('status',['active','inactive'])->default('active');
        });
        Schema::table('product_sizes', function (Blueprint $table) {
            $table->enum('status',['active','inactive'])->default('active');
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
