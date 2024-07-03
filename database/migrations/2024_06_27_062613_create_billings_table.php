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
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('firstName',20);
            $table->string('lastName',20);
            $table->string('email');
            $table->text('address');
            $table->integer('zipCode')->length(6)->unsigned();
            $table->integer('mobileNumber')->length(10)->unsigned();
            $table->string('country',10);
            $table->string('state',10);
            $table->string('city',10);
            $table->double('shippingCost',6,2);
            $table->timestamps();
            
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
