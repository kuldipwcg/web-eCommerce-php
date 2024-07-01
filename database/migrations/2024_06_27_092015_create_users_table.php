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
        $table->id();
        $table->string('first_name',20);
        $table->string('last_name',20);
        $table->string('email')->unique();
        $table->string('password');
        $table->string('confirm_password');
        $table->string('dob')->nullable();
        $table->string('phone_no',10)->nullable();
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

