<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use App\Models\User;

class DBBuilder extends BaseService
{
    public static function run(): void
    {
        // app()->info('Building database...');
        file_put_contents(database_path('database.sqlite'), '');
        Artisan::call('migrate:fresh');
        // Artisan::call('db:seed');
        User::create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => bcrypt(request()->password),
        ]);
    }
}