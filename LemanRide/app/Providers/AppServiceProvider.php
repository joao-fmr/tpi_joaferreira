<?php
/**
 * ETML
 * Author : João Ferreira
 * Date : 30.05.2023
 * Description : AppServiceProvider class used to register and boot application services.
 *               It registers a singleton instance of the Wind Api Service class.
 */


namespace App\Providers;

use App\Services\WindApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // register a single Wind Api Service that retrieves data from the API
        $this->app->singleton(WindApiService::class, function ($app) {
            return new WindApiService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
