<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    public static function get(string $key): string
    {
        return self::where('key', $key)->first() ?? "";
    }

    public static function set(string $key, string $value): void
    {
        if($setting = self::where('key', $key)->first()) {
            $setting->value = $value;
            $setting->save();
            return;
        }
        Setting::create([
            'key' => $key,
            'value' => $value,
        ]);
    }
}
