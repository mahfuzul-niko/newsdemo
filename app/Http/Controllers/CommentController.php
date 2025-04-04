<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentVote;
use App\Models\News;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function reply($id, Request $request)
    {
        $news = News::find($id);
        $request->validate([
            'comment' => ['required', 'string'],
        ]);
        $comment = new Comment;

        $comment->user_id = auth()->user()->id;
        $comment->news_id = $news->id;
        $comment->comment = $request->comment;
        $comment->parent_id = $request->parent;
        $comment->save();
        return redirect()->back()->with('success', 'comment added successfully');
    }
    public function commentVote(Comment $comment, Request $request)
    {
        $request->validate([
            'vote_type' => ['required', 'in:0,1'],
        ]);
        if ($request->vote_type == 1) {
            $comment->increment('score', 1);
        } else {
            $comment->decrement('score', 1);
        }
        if ($comment->users()->find(auth()->user())?->pivot->vote_type == $request->vote_type) {
            if ($request->vote_type != 1) {
                $comment->increment('score', 1);
            } else {
                $comment->decrement('score', 1);
            }
            $comment->users()->detach(auth()->user());
        } else {
            $comment->users()->sync([auth()->id() => ['vote_type' => $request->vote_type]]);
        }
        return redirect()->back();
    }
    public function commentSave(Comment $comment, Request $request)
    {
        $save = $comment->commentsavedBy()->find(auth()->id());
        if ($save) {
            $comment->commentsavedBy()->detach(auth()->id());
            $message = 'Comment unsaved';
        } else {
            $comment->commentsavedBy()->sync(auth()->id());
            $message = 'Comment saved';
        }
        return redirect()->back()->with('success', $message);
    }
    public function commentReport(Comment $comment, Request $request)
    {
        $report = $comment->reportsavedBy()->find(auth()->id());
        if ($report) {
            $comment->reportsavedBy()->detach(auth()->id());
        } else {
            $comment->reportsavedBy()->sync(auth()->id());
        }
        return redirect()->back();
    }
}
