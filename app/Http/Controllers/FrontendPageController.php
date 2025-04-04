<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Page;
use Illuminate\Http\Request;

class FrontendPageController extends Controller
{
    public function page($page)
    {
    $page = Page::where('slug',$page)->firstOrFail();
        return view('pages.page', compact('page'));
    }
    public function shorts(Request $request)
    {
        $page =  $request->input('page') ?? 1;
        $news = News::with('translations', 'images')->withCount('images', 'comments')->orderByDesc('comments_count')->orderByDesc('shares')->latest()->paginate(5, ['*'], 'interestedNews', $page);
        foreach ($news as $item) {
            $item->increment('display_count');
        }
        $categories = Category::all();
        return view('pages.shorts', compact('categories', 'news'));
    }
}
