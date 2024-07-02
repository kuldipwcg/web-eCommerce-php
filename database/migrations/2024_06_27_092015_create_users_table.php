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
    Schema::create('users', function (Blueprint $table) {
        // $table->uuid('id')->primary();
        $table->id();
        $table->string('firstName',20);
        $table->string('lastName',20);
        $table->string('image');
        $table->string('email')->unique();
        $table->string('password')->nullable();
        $table->string('confirmPassword')->nullable();
        $table->string('dob')->nullable();
        $table->string('phoneNo',10)->nullable();
        $table->text('address')->nullable();
        $table->enum('role',array('user','admin'))->default('user');
        $table->timestamp('email_verified_at')->nullable();
        $table->rememberToken();
        $table->timestamps();
        $table->softDeletes();
    });
}

/**
 * Reverse the migrations.
 */
public function down(): void
{
    Schema::dropIfExists('users');
}
}; 

