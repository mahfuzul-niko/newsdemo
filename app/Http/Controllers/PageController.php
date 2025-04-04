<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
        ]);

        Page::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'slug' => $request->input('slug') ?? \Illuminate\Support\Str::slug($request->input('title')),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    // Update the specified page in storage
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
        ]);

        $page->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'slug' => $request->input('slug') ?? \Illuminate\Support\Str::slug($request->input('title')),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    // Remove the specified page from storage
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }

}
