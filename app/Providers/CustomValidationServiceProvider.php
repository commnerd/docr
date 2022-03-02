<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
            $compareKey = "database.connections.";

            foreach(request()->all() as $key => $val) {
                if(Config::hasKey($key) && substr($key, 0, len($compareKey)) == $compareKey) {
                    Config::set($key, $val);
                }
            }
            
            try {
                DB::connection(request()->input('database.default'))->getPDO();
                DB::connection(request()->input('database.default'))->getDatabaseName();
            } catch (\Exception $e) {
                return false;
            }
    
            return true;
        });
    }
}
