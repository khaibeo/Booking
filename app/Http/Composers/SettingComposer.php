<?php

namespace App\Http\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class SettingComposer
{
    public function compose(View $view)
    {
        $settings = Setting::query()->first();
        $view->with('settings', $settings);
    }
}
