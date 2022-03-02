<?php

namespace App\Http\Controllers;

// Laravel imports
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

// Project imports
use App\Models\Setting;
use App\Models\User;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        return response()->view('configuration.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'database_default' => 'required|string|connects|in:sqlite,mysql,pgsql',
        ]);
       
        Artisan::call('migrate --force');

        foreach($request->all() as $key => $val) {
            if(Config::get(str_replace('_', '.', $key))) {
                Setting::set(str_replace('_', '.', $key), $val);
            }
        }

        Setting::set('app.key', Config::get('app.key'));

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect('/');
    }
}
