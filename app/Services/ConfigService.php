<?php

namespace App\Services;

class ConfigService extends BaseService
{
    public static function run(): void
    {
        EnvBuilder::run();
        DBBuilder::run();
        
    }
}