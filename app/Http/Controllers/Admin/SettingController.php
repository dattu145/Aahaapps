<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index', [
            'logo' => Setting::get('logo'),
            'whatsapp_number' => Setting::get('whatsapp_number'),
            'min_login_url' => Setting::get('min_login_url'),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|max:2048',
            'whatsapp_number' => 'nullable|string|max:20',
            'min_login_url' => 'nullable|url',
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('uploads', 'public');
            
            // Delete old logo if exists
            $oldLogo = Setting::get('logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            Setting::set('logo', $path);
        }

        if ($request->has('whatsapp_number')) {
            Setting::set('whatsapp_number', $request->input('whatsapp_number'));
        }

        if ($request->has('min_login_url')) {
            Setting::set('min_login_url', $request->input('min_login_url'));
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
