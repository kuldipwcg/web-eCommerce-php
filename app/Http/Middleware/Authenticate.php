<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('error');
    }
}

// admins
// $table->id();
// $table->string('name')->nullable();
// $table->string('email')->unique();
// $table->string('password');
// $table->softDeletes();
// $table->timestamps(); 

$table->id()->primary();
$table->string('email');
$table->timestamps();
$table->softDeletes();