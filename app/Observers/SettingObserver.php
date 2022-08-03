<?php

namespace App\Observers;

use App\Models\Setting;
use Cache;

class SettingObserver
{
    public function updated(Setting $setting): void
    {
        Cache::forget('settings');
    }

    public function created(Setting $setting): void
    {
        Cache::forget('settings');
    }
}
