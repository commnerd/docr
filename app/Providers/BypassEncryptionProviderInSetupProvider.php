<?php

namespace App\Providers;

// Laravel includes
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

// Project includes
use App\Traits\EncryptionGeneratorTrait;
use App\Traits\ConfigurationCheckerTrait;

use App\Models\Setting;

class BypassEncryptionProviderInSetupProvider extends ServiceProvider
{
    use ConfigurationCheckerTrait;
    use EncryptionGeneratorTrait;

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
        Config::set('app.key', $this->getEncryptionKey());
        if($this->configured()) {
            Config::set('app.key', Setting::get('app.key'));
        }  
    }
}
