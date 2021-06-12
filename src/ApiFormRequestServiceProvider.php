<?php

namespace Mawuekom\ApiFormRequest;

use Illuminate\Support\ServiceProvider;

class ApiFormRequestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Register the main class to use with the facade
        $this->app->singleton('api-form-request', function () {
            return new ApiFormRequest;
        });

        $this ->app ->register('Mawuekom\FormRequest\FormRequestServiceProvider');
    }
}
