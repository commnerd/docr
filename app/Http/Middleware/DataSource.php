<?php

namespace App\Http\Middleware;

// Laravel imports
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Closure;

// Project imports
use App\Traits\ConfigurationCheckerTrait;
use App\Traits\EncryptionGeneratorTrait;
use App\Models\Setting;
use App\Models\User;

class DataSource
{

    use ConfigurationCheckerTrait;
    use EncryptionGeneratorTrait;

    private $encryptionKey = null;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$this->configured() && $request->is('configure*')) {
            return $next($request);
        }

        $dbType = Setting::get("database.default") || "sqlite";
        Config::set("database.default", $dbType);
        Config::set("telescope.storage.database.connection", $dbType);
        Config::set("app.key", Setting::get("app.key"));

        $this->configure();        
        
        try {
            foreach(Setting::all() as $key => $val) {
                Config::set($key, $val);
            }
        }
        catch(\ErrorException $e) {
            // Do nothing
        }
        
        return $next($request);
    }

    private function configure(): void
    {
        if(!$this->isFileCreated()) {
            $this->createDbFile();
        }

        if(!$this->isDbInitialized()) {
            $this->initializeDb();
        }
    }

    private function initializeDb(): void
    {
        Artisan::call("migrate --force");

        Setting::create([
            'key' => 'app.key',
            'value' => $this->encryptionKey
        ]);

        Config::set('app.key', $this->encryptionKey);
    }

    private function isDbInitialized(): bool
    {
        return Schema::hasTable("migrations") && Setting::count() > 0;
    }

    private function createDbFile(): void
    {
        $dbType = Config::get("database.default");
        $dbFile = Config::get("database.connections.$dbType.database");
        touch($dbFile);
    }

    private function isFileCreated(): bool
    {
        $dbType = Config::get("database.default");
        $dbFile = Config::get("database.connections.$dbType.database");
        return file_exists($dbFile);
    }
}
