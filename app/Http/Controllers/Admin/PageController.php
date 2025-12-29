<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta_description' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:1024',
            'cta_text' => 'nullable|string|max:50',
            'cta_url' => 'nullable|url',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('pages', 'public');
        }

        Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta_description' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:1024',
            'cta_text' => 'nullable|string|max:50',
            'cta_url' => 'nullable|url',
        ]);
        
        $validated['is_active'] = $request->has('is_active');
        
        if ($request->hasFile('image')) {
            if ($page->image && Storage::disk('public')->exists($page->image)) {
                Storage::disk('public')->delete($page->image);
            }
            $validated['image'] = $request->file('image')->store('pages', 'public');
        }

        $page->update($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        if ($page->image && Storage::disk('public')->exists($page->image)) {
            Storage::disk('public')->delete($page->image);
        }
        $page->delete();
        return back()->with('success', 'Page deleted successfully.');
    }
}
