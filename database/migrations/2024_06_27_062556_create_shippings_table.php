<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('firstName', 20);
            $table->string('lastName', 20);
            $table->string('email');
            $table->integer('mobileNumber')->length(10)->unsigned();
            $table->text('address1');
            $table->text('address2');
            $table->integer('zipCode')->length(6)->unsigned();
            $table->string('country', 10);
            $table->string('state', 10);
            $table->string('city', 10);
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
