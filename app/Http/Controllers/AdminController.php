<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::count();

        $allNewsCount = News::count();
        $allCommentsCount = Comment::count();

        $recentNews = News::latest()->take(5)->get();

        $recentUser = User::latest()->take(5)->get();


        return view('admin.dashboard', [
            'users' => $users,
            'allNewsCount' => $allNewsCount,
            'allCommentsCount' => $allCommentsCount,
            'recentNews' => $recentNews,
            'recentUser' => $recentUser,
        ]);
    }

    public function commentIndex()
    {
        $comments = Comment::with(['owner', 'news'])->latest()->paginate(10);

        return view('admin.comments.index', compact('comments'));
    }

    public function commentUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->status = $request->status;
        $comment->save();

        return redirect()->route('admin.comments.index')->with('status', 'Comment status updated successfully!');
    }
    public function search(Request $request)
    {
        $query = $request->input('q');


        $comments = Comment::where('comment', 'LIKE', "%$query%")
        ->orWhereHas('news',function ($q) use($query) {return $q->where('title', 'LIKE', "%$query%");} )
        ->orWhereHas('users',function ($q) use($query) {return $q->where('name', 'LIKE', "%$query%");} )
            ->paginate(10);

        return view('admin.comments.index', compact('comments'));
    }
}
