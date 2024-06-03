<?php

namespace Rochmadnf\Recail;

use Illuminate\Support\ServiceProvider;

class ReactEmailServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/react-email.php' => config_path('react-email.php'),
        ]);
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/react-email.php',
            'react-email'
        );
    }
}
