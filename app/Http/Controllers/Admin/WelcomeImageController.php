<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WelcomeImage;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WelcomeImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = WelcomeImage::ordered()->get();
        $marquee_speed = Setting::where('key', 'marquee_speed')->value('value') ?? 40;
        $iframe_width = Setting::where('key', 'iframe_width')->value('value') ?? '220px';
        $iframe_height = Setting::where('key', 'iframe_height')->value('value') ?? '100vh';
        
        return view('admin.welcome_images.index', compact('images', 'marquee_speed', 'iframe_width', 'iframe_height'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.welcome_images.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'iframe_url' => 'required|url',
            'sort_order' => 'nullable|integer',
        ]);

        WelcomeImage::create([
            'type' => 'iframe',
            'image_path' => null,  // Explicitly set to NULL for iframes
            'iframe_url' => $request->iframe_url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.welcome-images.index')
            ->with('success', 'Website added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WelcomeImage $welcomeImage)
    {
        return view('admin.welcome_images.edit', compact('welcomeImage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WelcomeImage $welcomeImage)
    {
        $request->validate([
            'iframe_url' => 'required|url',
            'sort_order' => 'nullable|integer',
        ]);

        $welcomeImage->update([
            'type' => 'iframe',
            'image_path' => null,  // Explicitly set to NULL for iframes
            'iframe_url' => $request->iframe_url,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.welcome-images.index')->with('success', 'Website updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WelcomeImage $welcomeImage)
    {
        $welcomeImage->delete();

        return redirect()->route('admin.welcome-images.index')->with('success', 'Website deleted successfully.');
    }

    /**
     * Update global settings for iframe display
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'marquee_speed' => 'nullable|integer|min:5|max:200',
            'iframe_width' => 'nullable|string|max:20',
            'iframe_height' => 'nullable|string|max:20',
        ]);

        // Update or create marquee speed
        if ($request->has('marquee_speed')) {
            Setting::updateOrCreate(
                ['key' => 'marquee_speed'],
                ['value' => $request->marquee_speed]
            );
        }

        // Update or create iframe width
        if ($request->has('iframe_width')) {
            Setting::updateOrCreate(
                ['key' => 'iframe_width'],
                ['value' => $request->iframe_width]
            );
        }

        // Update or create iframe height
        if ($request->has('iframe_height')) {
            Setting::updateOrCreate(
                ['key' => 'iframe_height'],
                ['value' => $request->iframe_height]
            );
        }

        return redirect()->route('admin.welcome-images.index')->with('success', 'Settings updated successfully.');
    }
}
