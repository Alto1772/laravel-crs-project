<?php

namespace App\Providers;

use Illuminate\Routing\RouteRegistrar;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ApiPrefixProvider extends ServiceProvider
{
    /**
     * Register the apiPrefix macro for shorter expressions on API type routes
     */
    public function boot(): void
    {
        Route::macro('apiPrefix', function (string|array|null $middleware = null): RouteRegistrar {
            $middleware = Arr::wrap($middleware);
            $middleware[] = 'api';

            return Route::prefix('/api')->middleware($middleware)->name('api.');
        });
    }
}
