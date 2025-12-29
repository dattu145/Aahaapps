<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $items = MenuItem::ordered()->get();
        return view('admin.menus.index', compact('items'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        MenuItem::create($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit(MenuItem $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, MenuItem $menu)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);
        
        // Handle checkbox not sending 'false'
        $validated['is_active'] = $request->has('is_active');

        $menu->update($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(MenuItem $menu)
    {
        $menu->delete();
        return back()->with('success', 'Menu deleted successfully.');
    }
}
