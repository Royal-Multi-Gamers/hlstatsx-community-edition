<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'hlstats_Options';
    protected $primaryKey = 'keyname';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['keyname', 'value'];

    /** In-process cache — populated with a single SELECT * on first access. */
    private static array $_cache = [];
    private static bool  $_loaded = false;

    public static function get(string $key, mixed $default = null): mixed
    {
        if (!self::$_loaded) {
            self::$_cache  = static::all()->pluck('value', 'keyname')->all();
            self::$_loaded = true;
        }

        return self::$_cache[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['keyname' => $key], ['value' => $value]);
        self::$_cache[$key] = $value;
    }

    /** Force a reload on next get() — useful in tests or after bulk imports. */
    public static function flushCache(): void
    {
        self::$_loaded = false;
        self::$_cache  = [];
    }
}
