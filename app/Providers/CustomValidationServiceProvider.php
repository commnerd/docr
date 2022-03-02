<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

use App\Validators\DBConnectionValidator;

class CustomValidationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('connects', function($attribute, $value, $parameters)
        {            
            try {
                DB::connection(request()->input('database_default'))->getPDO();
                DB::connection(request()->input('database_default'))->getDatabaseName();
            } catch (\Exception $e) {
                return false;
            }

            return true;
        });
    }
}
