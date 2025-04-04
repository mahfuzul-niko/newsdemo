<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class LoaderController extends Controller
{
    public function loadMoreNews(Request $request)
    {
        $page =  $request->input('page') ?? 2;
        $news = News::interested()->with('translations', 'images')->withCount('images', 'comments')->orderByDesc('processed_timestamp')->paginate(5, ['*'], 'interestedNews', $page);
        foreach ($news as $item) {
            $item->increment('display_count');
        }
        return [
            'news' => view('partials.news', compact('news'))->render(),
            'next_page' => $page + 1,
            'prev_page' => $page - 1 ? $page - 1 : 1,
        ];
    }

    public function loadMoreTrendingNews(Request $request)
    {
        $page =  $request->input('page') ?? 2;
        $news = News::with('translations', 'images')->withCount('images', 'comments')->orderByDesc('comments_count')->orderByDesc('shares')->latest()->paginate(5, ['*'], 'interestedNews', $page);
        foreach ($news as $item) {
            $item->increment('display_count');
        }

        return [
            'news' => view('partials.news', compact('news'))->render(),
            'next_page' => $page + 1,
            'prev_page' => $page - 1 ? $page - 1 : 1,
        ];
    }
}
