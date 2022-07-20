<?php

namespace App\Services;

use App\Models\Setting;
use Cache;
use Illuminate\Support\Collection;

class SettingsService
{
    private array $container = [];

    public function __construct()
    {
        $this->boot();
    }

    private function boot(): void
    {
        /** @var Collection $settings*/
        $this->container = Cache::rememberForever('settings', function () {
            return Setting::all()->mapWithKeys(function (Setting $setting) {
                return [$setting->hash => $setting->content];
            })->toArray();
        });
    }
    public function get(string $key, mixed $default = ''): mixed
    {
        return $this->container[$this->makeKey($key)] ?? $default;
    }

    private function makeKey(string $key): string
    {
        return md5($key);
    }
}
