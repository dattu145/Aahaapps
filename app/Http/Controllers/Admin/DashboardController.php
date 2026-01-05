<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CircularItem;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'cards_count' => CircularItem::count(),
            'pages_count' => Page::count(),
            'menus_count' => MenuItem::count(),
            'users_count' => User::count(),
        ];

        $recent_cards = CircularItem::latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recent_cards'));
    }
}
