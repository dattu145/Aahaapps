<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        // Default to 'home' page if exists, else show welcome
        $page = Page::where('slug', 'home')->where('is_active', true)->first();

        if (!$page) {
            return view('welcome');
        }

        $services = \App\Models\Service::active()->ordered()->get();

        return view('page', compact('page', 'services'));
    }

    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('page', compact('page'));
    }
}
