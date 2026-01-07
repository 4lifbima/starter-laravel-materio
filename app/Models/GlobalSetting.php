<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class GlobalSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
    ];

    /**
     * Cache key prefix for settings.
     */
    protected static string $cachePrefix = 'global_setting_';

    /**
     * Get the typed value of the setting.
     */
    public function getTypedValueAttribute()
    {
        return match ($this->type) {
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }

    /**
     * Set the value with type conversion.
     */
    public function setTypedValueAttribute($value): void
    {
        $this->value = match ($this->type) {
            'boolean' => $value ? 'true' : 'false',
            'json' => json_encode($value),
            default => (string) $value,
        };
    }

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever(static::$cachePrefix . $key, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->typed_value : $default;
        });
    }

    /**
     * Set a setting value by key.
     */
    public static function set(string $key, $value, string $type = 'text', string $group = 'general'): self
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => static::convertValue($value, $type), 'type' => $type, 'group' => $group]
        );

        Cache::forget(static::$cachePrefix . $key);

        return $setting;
    }

    /**
     * Convert value based on type.
     */
    protected static function convertValue($value, string $type): string
    {
        return match ($type) {
            'boolean' => $value ? 'true' : 'false',
            'json' => json_encode($value),
            default => (string) $value,
        };
    }

    /**
     * Get all settings in a group.
     */
    public static function getGroup(string $group): array
    {
        return static::where('group', $group)
            ->get()
            ->mapWithKeys(fn ($setting) => [$setting->key => $setting->typed_value])
            ->toArray();
    }

    /**
     * Clear all cached settings.
     */
    public static function clearCache(): void
    {
        static::all()->each(function ($setting) {
            Cache::forget(static::$cachePrefix . $setting->key);
        });
    }

    /**
     * Boot the model to clear cache on changes.
     */
    protected static function booted(): void
    {
        static::saved(function ($setting) {
            Cache::forget(static::$cachePrefix . $setting->key);
        });

        static::deleted(function ($setting) {
            Cache::forget(static::$cachePrefix . $setting->key);
        });
    }
}
