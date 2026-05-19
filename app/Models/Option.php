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

    public static function get(string $key, mixed $default = null): mixed
    {
        $option = static::find($key);
        return $option ? $option->value : $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['keyname' => $key], ['value' => $value]);
    }
}
