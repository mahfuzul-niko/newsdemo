<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Support\Facades\Request;

class NewsController extends Controller
{
    public function index()
    {
        
        $allnews = News::withoutGlobalScopes(['active'])->latest()->withCount('comments')->when(request()->filled('q'), function ($q) {
            $query = request()->q;
            $q->where('title', 'LIKE', "%$query%")
                ->orWhere('keywords', 'LIKE', "%$query%")
                ->orWhere('key_figures', 'LIKE', "%$query%");
        })->paginate(20);
        return view('admin.news.index', compact('allnews'));
    }

    
    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }
}
