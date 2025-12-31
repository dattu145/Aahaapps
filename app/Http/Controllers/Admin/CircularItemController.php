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
            'sort_order' => 'nullable|integer',
        ]);

        CircularItem::create([
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'link' => $request->link,
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
            'sort_order' => 'nullable|integer',
        ]);

        $circularItem->update([
            'title' => $request->title,
            'description' => $request->description,
            'button_text' => $request->button_text,
            'link' => $request->link,
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
}
