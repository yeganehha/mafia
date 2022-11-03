<?php

namespace App\Services\Admin\Settings;

use App\Models\Setting;

class SettingService
{
    public function updateSettings($data)
    {
        $setting = new Setting();
        $setting->updateSettings($data);
    }
}
