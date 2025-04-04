<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
   public function viewProfile()
   {
      return view('pages.profile.profile');
   }
   public function showProfileForm()
   {
      return view('pages.profile.edit');
   }
   public function updateProfile(Request $request)
   {
      $request->validate([
         'name' => 'required|string|max:30',
         'username' => 'required|string|max:30',
         'website' => 'nullable|string|max:50',
         'bio' => 'nullable|string|max:150',
         'avatar' => 'nullable|mimes:jpeg,jpg,png|max:5000',
      ]);

      $user = auth()->user();
      $data = [
         'name' => $request->name,
         'username' => $request->username,
         'website' => $request->website,
         'bio' => $request->bio,
      ];
      if ($request->has('avatar')) {
         if (Storage::exists($user->avatar)) {
            Storage::delete($user->avatar);
         }
         $data['avatar'] = $request->avatar->store('avatar');
      }
      $user->update($data);

      return redirect()->back()->with('success', 'Profile updated successfully');
   }

   public function savedNews()
   {

      return view('pages.profile.saved-news');
   }

   public function loadBookmarks(Request $request)
   {
      $news = auth()->user()->savedNews()->with('translations', 'images')->withCount('images', 'comments')->orderByDesc('id')->cursorPaginate(6, ['*'], 'cursor', $request->input('cursor'));
      return [
         'empty' => auth()->user()->savedNews->count() ? false : true,
         'news' => view('partials.news', compact('news'))->render(),
         'next_cursor' => optional($news->nextCursor())->encode(),
         'prev_cursor' => optional($news->previousCursor())->encode(),
      ];
   }
}
