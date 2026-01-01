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
        // Custom Premium Homepage Logic with Performance Optimizations
        // Cache frequently accessed data with 1-hour TTL to reduce database queries
        
        // Cache content queries - these rarely change
        $welcomeImages = cache()->remember('homepage.welcome_images', 3600, function() {
            return WelcomeImage::active()->ordered()->get();
        });
        
        
        $circularItems = CircularItem::active()->ordered()->get();
        
        $services = cache()->remember('homepage.services', 3600, function() {
            return Service::active()->ordered()->get();
        });
        
        $menuItems = cache()->remember('homepage.menu_items', 3600, function() {
            return MenuItem::orderBy('order')->get();
        });
        
        // Use same cached menu data instead of querying twice
        $globalMenu = $menuItems;
        
        // Bulk load all settings in one query instead of 5 separate queries
        $settings = cache()->remember('homepage.settings', 3600, function() {
            return Setting::whereIn('key', [
                'logo_url', 
                'logo', 
                'marquee_speed', 
                'iframe_width', 
                'iframe_height'
            ])->pluck('value', 'key');
        });
        
        $globalSettings = [
            'logo_url' => $settings->get('logo_url'),
            'logo' => $settings->get('logo'),
        ];

        // Get settings with defaults
        $marquee_speed = $settings->get('marquee_speed', 40);
        $iframe_width = $settings->get('iframe_width', '220px');
        $iframe_height = $settings->get('iframe_height', '100vh');
        
        return view('welcome', compact('welcomeImages', 'circularItems', 'services', 'menuItems', 'globalMenu', 'globalSettings', 'marquee_speed', 'iframe_width', 'iframe_height'));
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('page', compact('page'));
    }
}
