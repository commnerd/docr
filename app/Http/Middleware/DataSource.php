<?php

namespace App\Http\Middleware;

// Laravel imports
use Illuminate\Http\Request;
use Closure;

// Project imports
use App\Models\Setting;

class DataSource
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $dbType = Setting::get("database.default");
        Config::set("database.default", $dbType);

        foreach(Setting::where("key", "like", "database.connections.$dbType%")->get() as $key => $val) {
            Config::set($key, $val);
        }

        return $next($request);
    }
}
