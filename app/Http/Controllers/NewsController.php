<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\SaveNews;
use Illuminate\Http\Request;
use Illuminate\Pagination\Cursor;

class NewsController extends Controller
{
    public function saveNews($id)
    {


        $news = News::find($id);

        $bookmark = $news->savedBy()->find(auth()->id());
        if ($bookmark) {
            $news->savedBy()->detach(auth()->id());
        } else {
            $news->savedBy()->sync(auth()->id());
        }

        return response()->json('success');
    }

    public function share($id)
    {
        $news = News::find($id);
        $news->increment('shares');
        return response()->json('News shared');
    }

    public function read($id)
    {
        $news = News::find($id);

        $news->increment('view_count');
        $read = $news->reads()->create([
            'user_id' => auth()->id(),
            'ip' => $_SERVER['REMOTE_ADDR'],
            'device' => $_SERVER['HTTP_USER_AGENT'],
        ]);

        return response()->json($read);
    }
}
