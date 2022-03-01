<?php

namespace App\Services\DB;

class MySQLBuilder extends DBBuilder {
    public static function run(): void {
        echo 'MySQLBuilder::run()' . PHP_EOL;
    }
}