<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class OriginAuthProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'originAuth',
            'App\Http\Components\OriginAuth'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
