<?php

namespace Gamebetr\ApiClientPhp\Providers;

use Gamebetr\ApiClientPhp\Services\ApiClientService;
use Illuminate\Support\ServiceProvider;

class ApiClientPhpServiceProvider extends ServiceProvider
{
    /**
     * Register method.
     * @return void
     */
    public function register()
    {
        // ApiClient facade
        $this->app->bind('api-client-service', function () {
            return new ApiClientService(config('api-client-php'));
        });
    }

    /**
     * Boot method.
     * @return void
     */
    public function boot()
    {
        // config
        $this->mergeConfigFrom(__DIR__.'/../../config/api-client-php.php', 'api-client-php');
        $this->publishes([__DIR__.'/../../config' => config_path()], 'config');
    }
}
