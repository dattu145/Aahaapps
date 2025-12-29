<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        // Custom Premium Homepage Logic
        // We use 'welcome.blade.php' for the "/" route to support the new custom design.
        // We still fetch content if needed, but the view is specific.
        $services = \App\Models\Service::active()->ordered()->get();
        // $page = Page::where('slug', 'home')->where('is_active', true)->first(); 

        return view('welcome', compact('services'));
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('page', compact('page'));
    }
}
