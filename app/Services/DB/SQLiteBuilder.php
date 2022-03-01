<?php

namespace App\Services\DB;

class SQLiteBuilder implements DBBuilder
{
    public static function run(): void
    {
        echo 'SQLiteBuilder::run()' . PHP_EOL;
    }
}