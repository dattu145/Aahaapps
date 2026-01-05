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
            'logo_url' => Setting::get('logo_url'),
            'logo_height' => Setting::get('logo_height'),
            'logo_width' => Setting::get('logo_width'),
            'whatsapp_number' => Setting::get('whatsapp_number'),
            'social_email' => Setting::get('social_email'),
            'social_linkedin' => Setting::get('social_linkedin'),
            'social_web' => Setting::get('social_web'),
            'company_address' => Setting::get('company_address'),
            'company_address_size' => Setting::get('company_address_size'),
            'min_login_url' => Setting::get('min_login_url'),
            'marquee_speed' => Setting::get('marquee_speed'),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|max:2048',
            'logo_url' => 'nullable|url',
            'logo_height' => 'nullable|integer|min:10|max:500',
            'logo_width' => 'nullable|string|max:10', // Allow "auto" or number
            'whatsapp_number' => 'nullable|string|max:20',
            'social_email' => 'nullable|email',
            'social_linkedin' => 'nullable|url',
            'social_web' => 'nullable|url',
            'company_address' => 'nullable|string|max:500',
            'company_address_size' => 'nullable|integer|min:8|max:50',
            'min_login_url' => 'nullable|url',
            'marquee_speed' => 'nullable|integer|min:5|max:200',
        ]);

        if ($request->has('logo_height')) {
            Setting::set('logo_height', $request->input('logo_height'));
        }
        if ($request->has('logo_width')) {
            Setting::set('logo_width', $request->input('logo_width'));
        }

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('uploads', 'public');
            
            // Delete old logo
            $oldLogo = Setting::get('logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            Setting::set('logo', $path);
            Setting::set('logo_url', null); 
        } elseif ($request->filled('logo_url')) {
            Setting::set('logo_url', $request->input('logo_url'));
        }

        if ($request->has('whatsapp_number')) {
            Setting::set('whatsapp_number', $request->input('whatsapp_number'));
        }

        // Save Social & Address Settings
        if ($request->has('social_email')) Setting::set('social_email', $request->input('social_email'));
        if ($request->has('social_linkedin')) Setting::set('social_linkedin', $request->input('social_linkedin'));
        if ($request->has('social_web')) Setting::set('social_web', $request->input('social_web'));
        if ($request->has('company_address')) Setting::set('company_address', $request->input('company_address'));
        if ($request->has('company_address_size')) Setting::set('company_address_size', $request->input('company_address_size'));

        if ($request->has('min_login_url')) {
            Setting::set('min_login_url', $request->input('min_login_url'));
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
