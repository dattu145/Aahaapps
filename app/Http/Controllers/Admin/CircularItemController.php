<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CircularItem;
use Illuminate\Http\Request;

class CircularItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $items = CircularItem::ordered()->get();
        return view('admin.circular_items.index', compact('items'));
    }

    public function create()
    {
        return view('admin.circular_items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'button_text' => 'required|string|max:255',
            'link' => 'required|string',
            'color' => 'nullable|string|max:255',
            'text_color' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        CircularItem::create([
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'link' => $request->link,
            'color' => $request->color,
            'text_color' => $request->text_color,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.circular-items.index')
            ->with('success', 'Circular Item created successfully.');
    }

    public function edit(CircularItem $circularItem)
    {
        return view('admin.circular_items.edit', compact('circularItem'));
    }

    public function update(Request $request, CircularItem $circularItem)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'button_text' => 'required|string|max:255',
            'link' => 'required|string',
            'color' => 'nullable|string|max:255',
            'text_color' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $circularItem->update([
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'link' => $request->link,
            'color' => $request->color,
            'text_color' => $request->text_color,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.circular-items.index')
            ->with('success', 'Circular Item updated successfully.');
    }

    public function destroy(CircularItem $circularItem)
    {
        $circularItem->delete();
        return redirect()->route('admin.circular-items.index')
            ->with('success', 'Circular Item deleted successfully.');
    }

    public function updateDimensions(Request $request)
    {
        $request->validate([
            'card_width' => 'nullable|integer|min:100|max:500',
            'card_height' => 'nullable|integer|min:80|max:400',
            'card_border_radius' => 'nullable|integer|min:0|max:50',
            'card_animation_speed' => 'nullable|numeric|min:0.1|max:5',
        ]);

        if ($request->has('card_width')) {
            \App\Models\Setting::set('card_width', $request->input('card_width'));
        }

        if ($request->has('card_height')) {
            \App\Models\Setting::set('card_height', $request->input('card_height'));
        }

        if ($request->has('card_border_radius')) {
            \App\Models\Setting::set('card_border_radius', $request->input('card_border_radius'));
        }

        if ($request->has('card_animation_speed')) {
            \App\Models\Setting::set('card_animation_speed', $request->input('card_animation_speed'));
        }

        return redirect()->route('admin.circular-items.index')
            ->with('success', 'Card dimensions updated successfully.');
    }
}
