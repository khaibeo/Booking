<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Services\SettingService;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function show()
    {
        $settings = $this->settingService->getSetting();

        return view('setting', compact('settings'));
    }

    public function update(SettingRequest $request)
    {
        $settings = $this->settingService->getSetting();

        $this->settingService->update($settings, $request->validated());

        return back()->with('success', 'Cập nhật thành công');
    }
}
