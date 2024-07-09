<?php

namespace App\Providers;

use App\CustomPasswordBroker;
use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Passwords\PasswordBrokerManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
