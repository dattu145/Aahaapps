<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Service;
use App\Models\CircularItem;
use App\Models\WelcomeImage;
use App\Models\MenuItem;
use App\Models\Setting;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        // Custom Premium Homepage Logic
        // We use 'welcome.blade.php' for the "/" route to support the new custom design.
        // We still fetch content if needed, but the view is specific.
        $welcomeImages = WelcomeImage::active()->ordered()->get();
        $circularItems = CircularItem::active()->ordered()->get();
        $services = Service::active()->ordered()->get();
        $menuItems = MenuItem::orderBy('order')->get();
        $globalMenu = MenuItem::orderBy('order')->get();
        
        $globalSettings = [
            'logo_url' => Setting::where('key', 'logo_url')->value('value'),
            'logo' => Setting::where('key', 'logo')->value('value'),
        ];

        return view('welcome', compact('welcomeImages', 'circularItems', 'services', 'menuItems', 'globalMenu', 'globalSettings'));
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('page', compact('page'));
    }
}
