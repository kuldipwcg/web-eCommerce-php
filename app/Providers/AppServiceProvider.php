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
        Passport::ignoreRoutes();

        $this->app->extend('auth.password.broker', function ($service, $app) {
            return new PasswordBrokerManager($app);
        });

        $this->app->singleton('auth.password.broker.custom', function ($app) {
            return new CustomPasswordBroker(
                $app['auth.password.tokens'],
                $app['auth.providers.users'],
                $app['mailer'],
                $app['translator'],
                config('auth.passwords.users.email')
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
