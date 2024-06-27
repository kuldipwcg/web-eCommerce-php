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
        $table->uuid('id');
        $table->string('name');
        $table->string('first_name',20);
        $table->string('last_name',20);
        $table->string('email')->unique();
        $table->string('password');
        $table->string('dob');
        $table->string('phone_no',10);
        $table->text('address');
        $table->enum('role',array('user,admin'))->default('user');
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

