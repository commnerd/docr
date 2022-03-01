<?php

namespace App\Services;

class EnvBuilder extends BaseService {
    public static function run(): void {
        $env = [
            // 'APP_ENV' => 'production',
            // 'APP_DEBUG' => 'false',
            'APP_ENV' => 'local',
            'APP_DEBUG' => 'true',
            'APP_KEY' => 'base64:'.base64_encode(random_bytes(32)),
            'APP_URL' => 'http://localhost',
            'DB_CONNECTION' => request()->db_type,
        ];

        switch($env['DB_CONNECTION']) {
            case 'mysql':
                $env['DB_HOST'] = request()->db_host;
                $env['DB_PORT'] = request()->db_port;
                $env['DB_DATABASE'] = request()->db_name;
                $env['DB_USERNAME'] = request()->db_user;
                $env['DB_PASSWORD'] = request()->db_pass;
                break;
            case 'sqlite':
                $env['DB_DATABASE'] = database_path('database.sqlite');
                break;
        }

        file_put_contents(base_path('.env'), implode(PHP_EOL, array_map(function($key, $value) {
            return $key . '=' . $value;
        }, array_keys($env), $env)));
    }
}