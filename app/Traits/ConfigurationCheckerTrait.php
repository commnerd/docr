<?php

namespace App\Http\Middleware;

// Laravel imports
use Illuminate\Support\Facades\Schema;

// Project imports
use App\Models\Setting;
use App\Models\User;

trait ConfigurationCheckerTrait
{
    /**
     * Check if the application is configured.
     *
     * @return bool
     */
    private function configured(): bool
    {
        $dbType = config("database.default") || "sqlite";
        $sqlitePath = config("database.connections.$dbType.database");
        if (file_exists($sqlitePath) && Schema::hasTable("settings") && Setting::count() && User::count()) {
            return true;
        }
        return false;
    }
}