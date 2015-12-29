<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('relations', function ($attribute, $value, $parameters, $validator) {
            $query = explode(',', $value);

            sort($parameters);
            sort($query);

            foreach ($query as $q) {
                if (!in_array($q, $parameters)) {
                    return false;
                }
            }

            return true;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
