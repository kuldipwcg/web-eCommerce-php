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
        Schema::create('billings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_id');
            $table->string('first_name',20);
            $table->string('last_name',20);
            $table->string('email');
            $table->text('address');
            $table->integer('zip_code')->length(6)->unsigned();
            $table->integer('mobile_numer')->length(10)->unsigned();
            $table->string('country',10);
            $table->string('state',10);
            $table->string('city',10);
            $table->double('shipping_cost',6,2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
