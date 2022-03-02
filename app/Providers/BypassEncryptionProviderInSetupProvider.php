<?php

namespace App\Providers;

// Laravel includes
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

// Project includes
use App\Traits\EncryptionGeneratorTrait;
use App\Traits\ConfigurationCheckerTrait;

class BypassEncryptionProviderInSetupProvider extends ServiceProvider
{

    use EncryptionGeneratorTrait;
    use ConfigurationCheckerTrait;

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
        if(!$this->configured() && request()->is('configure*')) {
            Config::set('app.key', $this->getEncryptionKey());
        }
       
    }
}
