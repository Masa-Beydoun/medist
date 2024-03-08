<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function updateData(Request $request)
    {
        $pharmacist = Auth::guard('sanctum')->user();
        $updatedData = $request->all();
        $setting = $pharmacist->setting;
        if(!$setting) {
            $setting = Setting::create($updatedData);
            $pharmacist->setting()->save($setting);
        } else {
            $setting->update($updatedData);
            $pharmacist->setting()->save($setting);
        }
        return response()->json([
            'message' => 'Updated Successfully',
            'settings' => new SettingResource($setting),
        ],200);
    }
}
