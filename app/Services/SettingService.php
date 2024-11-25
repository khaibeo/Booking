<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    public function getSetting()
    {
        return Setting::query()->first();
    }

    public function update($setting, array $data)
    {
        $oldImage = $setting?->logo;

        if ($data['logo']) {
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
        } else {
            unset($data['logo']);
        }

        return $setting->update($data);
    }
}
