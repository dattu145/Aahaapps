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
            'description' => 'nullable|string',
            'link' => 'nullable|string',
            // Section 1
            'section1_images.*' => 'nullable|image|max:2048',
            'section1_image_width' => 'nullable|integer',
            'section1_image_height' => 'nullable|integer',
            // Section 2
            'section2_image_file' => 'nullable|image|max:2048',
            'section2_image_url' => 'nullable|url',
            // Section 3
            'buttons.*.text' => 'nullable|string|max:255',
           'buttons.*.link' => 'nullable|string',
            'buttons.*.bg_color' => 'nullable|string|max:7',
            'buttons.*.text_color' => 'nullable|string|max:7',
            'enquiry_link' => 'nullable|string',
            // Colors
            'card_bg_color' => 'nullable|string|max:7',
            'title_color' => 'nullable|string|max:7',
            'desc_color' => 'nullable|string|max:7',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle Section 1 multiple image uploads
        $section1Images = [];
        if ($request->hasFile('section1_images')) {
            foreach ($request->file('section1_images') as $image) {
                $path = $image->store('cards/section1', 'public');
                $section1Images[] = $path;
            }
        }

        // Handle Section 2 image upload (file has priority over URL)
        $section2Image = null;
        if ($request->hasFile('section2_image_file')) {
            $section2Image = $request->file('section2_image_file')->store('cards/section2', 'public');
        } elseif ($request->filled('section2_image_url')) {
            $section2Image = $request->input('section2_image_url');
        }

        // Process buttons data
        $buttons = [];
        if ($request->has('buttons')) {
            foreach ($request->input('buttons') as $button) {
                $buttons[] = [
                    'text' => $button['text'] ?? '',
                    'link' => $button['link'] ?? '#',
                    'bg_color' => $button['bg_color'] ?? '#111827',
                    'text_color' => $button['text_color'] ?? '#ffffff',
                ];
            }
        }

        CircularItem::create([
            'title' => $request->title,
            'description' => $request->description,
            // Section 1
            'section1_images' => $section1Images,
            'section1_image_width' => $request->section1_image_width,
            'section1_image_height' => $request->section1_image_height,
            // Section 2
            'section2_image' => $section2Image,
            // Section 3
            'buttons' => $buttons,
            'enquiry_link' => $request->enquiry_link,
            // Color overrides
            'card_bg_color' => $request->card_bg_color,
            'title_color' => $request->title_color,
            'desc_color' => $request->desc_color,
            // Other
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
            // Legacy fields (keep for backwards compatibility)
            'button_text' => 'Explore',
            'link' => $request->enquiry_link ?? '#',
            'color' => $request->card_bg_color,
            'text_color' => $request->title_color,
        ]);

        return redirect()->route('admin.circular-items.index')
            ->with('success', 'Home Page Card created successfully.');
    }

    public function edit(CircularItem $circularItem)
    {
        return view('admin.circular_items.edit', compact('circularItem'));
    }

    public function update(Request $request, CircularItem $circularItem)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|string',
            // Section 1
            'section1_images.*' => 'nullable|image|max:2048',
            'section1_image_width' => 'nullable|integer',
            'section1_image_height' => 'nullable|integer',
            // Section 2
            'section2_image_file' => 'nullable|image|max:2048',
            'section2_image_url' => 'nullable|url',
            // Section 3
            'buttons.*.text' => 'nullable|string|max:255',
            'buttons.*.link' => 'nullable|string',
            'buttons.*.bg_color' => 'nullable|string|max:7',
            'buttons.*.text_color' => 'nullable|string|max:7',
            'enquiry_link' => 'nullable|string',
            // Colors
            'card_bg_color' => 'nullable|string|max:7',
            'title_color' => 'nullable|string|max:7',
            'desc_color' => 'nullable|string|max:7',
            'sort_order' => 'nullable|integer',
        ]);

        // Handle Section 1 multiple image uploads (merge with existing)
        $section1Images = $circularItem->section1_images ?? [];
        if ($request->hasFile('section1_images')) {
            foreach ($request->file('section1_images') as $image) {
                $path = $image->store('cards/section1', 'public');
                $section1Images[] = $path;
            }
        }

        // Handle Section 2 image upload (file has priority over URL)
        $section2Image = $circularItem->section2_image;
        if ($request->hasFile('section2_image_file')) {
            $section2Image = $request->file('section2_image_file')->store('cards/section2', 'public');
        } elseif ($request->filled('section2_image_url')) {
            $section2Image = $request->input('section2_image_url');
        }

        // Process buttons data
        $buttons = [];
        if ($request->has('buttons')) {
            foreach ($request->input('buttons') as $button) {
                $buttons[] = [
                    'text' => $button['text'] ?? '',
                    'link' => $button['link'] ?? '#',
                    'bg_color' => $button['bg_color'] ?? '#111827',
                    'text_color' => $button['text_color'] ?? '#ffffff',
                ];
            }
        }

        $circularItem->update([
            'title' => $request->title,
            'description' => $request->description,
            // Section 1
            'section1_images' => $section1Images,
            'section1_image_width' => $request->section1_image_width,
            'section1_image_height' => $request->section1_image_height,
            // Section 2
            'section2_image' => $section2Image,
            // Section 3
            'buttons' => $buttons,
            'enquiry_link' => $request->enquiry_link,
            // Color overrides
            'card_bg_color' => $request->card_bg_color,
            'title_color' => $request->title_color,
            'desc_color' => $request->desc_color,
            // Other
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
            // Legacy fields (keep for backwards compatibility)
            'button_text' => 'Explore',
            'link' => $request->enquiry_link ?? '#',
            'color' => $request->card_bg_color,
            'text_color' => $request->title_color,
        ]);

        return redirect()->route('admin.circular-items.index')
            ->with('success', 'Home Page Card updated successfully.');
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
            'card_width' => 'nullable|integer|min:100|max:800',
            'card_height' => 'nullable|integer|min:80|max:600',
            'card_border_radius' => 'nullable|integer|min:0|max:50',
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

        return redirect()->route('admin.circular-items.index')
            ->with('success', 'Card dimensions updated successfully.');
    }
}
