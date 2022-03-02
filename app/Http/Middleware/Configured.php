<?php

namespace App\Http\Middleware;

// Laravel imports
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Closure;

// Project imports
use App\Traits\ConfigurationCheckerTrait;
use App\Models\Setting;
use App\Models\User;

class Configured
{
    use ConfigurationCheckerTrait;
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$this->configured() && !$request->is('configure*')) {
            return redirect()->route('configure.index');
        }

        if($this->configured() && $request->is('configure*')) {
            return redirect('/');
        }

        return $next($request);
    }
}
