<?php

namespace App\Http\Middleware;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\User;
use Closure;

class Configured
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
        if(!$this->configured() && !$request->is('configure*')) {
            return redirect()->route('configure.index');
        }

        if($this->configured() && $request->is('configure*')) {
            return redirect('/');
        }

        return $next($request);
    }

    private function configured(): bool {
        try {
            if(User::count() <= 0) {
                return false;
            }
        }
        catch (QueryException $e) {
            return false;
        }
        
        return true;
    }
}
