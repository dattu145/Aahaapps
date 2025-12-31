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
        $marquee_speed = Setting::get('marquee_speed', 40);
        return view('admin.welcome_images.index', compact('images', 'marquee_speed'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'marquee_speed' => 'required|integer|min:5|max:200',
        ]);

        Setting::set('marquee_speed', $request->input('marquee_speed'));

        return back()->with('success', 'Marquee speed updated successfully.');
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'nullable|integer',
            'target_url' => 'nullable|url',
            'opacity' => 'nullable|integer|min:0|max:100',
        ]);

        $imagePath = $request->file('image')->store('welcome_images', 'public');

        WelcomeImage::create([
            'image_path' => $imagePath,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
            'target_url' => $request->target_url,
            'opacity' => $request->opacity ?? 100,
        ]);

        return redirect()->route('admin.welcome-images.index')
            ->with('success', 'Image uploaded successfully.');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'nullable|integer',
            'target_url' => 'nullable|url',
            'opacity' => 'nullable|integer|min:0|max:100',
        ]);

        $data = [
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
            'target_url' => $request->target_url,
            'opacity' => $request->opacity ?? 100,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if (Storage::disk('public')->exists($welcomeImage->image_path)) {
                Storage::disk('public')->delete($welcomeImage->image_path);
            }
            $data['image_path'] = $request->file('image')->store('welcome_images', 'public');
        }

        $welcomeImage->update($data);

        return redirect()->route('admin.welcome-images.index')->with('success', 'Image updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WelcomeImage $welcomeImage)
    {
        if ($welcomeImage->image_path && Storage::disk('public')->exists($welcomeImage->image_path)) {
            Storage::disk('public')->delete($welcomeImage->image_path);
        }
        
        $welcomeImage->delete();

        return redirect()->route('admin.welcome-images.index')->with('success', 'Image deleted successfully.');
    }
}
