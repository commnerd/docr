<?php

namespace App\Http\Controllers;

// Laravel imports
use Illuminate\Support\Facades\Artisan;
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
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'database.default' => 'required|string|connects|in:sqlite,mysql,pgsql',
        ]);

        Artisan::call('migrate');

        foreach($request->all() as $key => $val) {
            if(Config::hasKey($key)) {
                Setting::set($key, $val);
            }
        }        

        return redirect('/');
    }
}
