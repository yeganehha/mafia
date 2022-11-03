<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\UpdateRequest;
use App\Models\Setting;
use App\Services\Admin\Settings\SettingService;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(UpdateRequest $request, SettingService $settingService)
    {
        $validData = $request->all();
        unset($validData['_token']);

        if (isset($validData['can_buy_coin'])) {
            $validData['can_buy_coin'] = 1;
        } else {
            $validData['can_buy_coin'] = 0;
        }

        try {
            $settingService->updateSettings($validData);
            return redirect()->back();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
