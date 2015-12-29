<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\JsonResponse;
use App\Libraries\ResponseBuilder;


class ResponseBuilderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Libraries\ResponseBuilder', function ($app) {
            return new ResponseBuilder(new JsonResponse());
        });
    }
}
