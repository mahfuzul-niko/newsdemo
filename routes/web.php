<?php

use App\Helpers\System;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FrontendPageController;
use App\Http\Controllers\LoaderController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Location;
use App\Models\News;
use App\Models\SaveNews;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Route;


Route::get('auth/social/{provider}/callback', [LoginController::class, 'socialLoginCallback']);
Route::get('auth/social/{provider}/redirect', [LoginController::class, 'socialLogin'])->name('auth.social');
Route::get('page/{page}', [FrontendPageController::class, 'page'])->name('view.about');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
Route::post('/password/confirm', [ConfirmPasswordController::class, 'confirm'])->name('password.confirm');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

Route::get('/share/{id}', [NewsController::class, 'share'])->name('news.share');
Route::get('/read/{id}', [NewsController::class, 'read'])->name('news.read');
Route::get('/save/{id}', [NewsController::class, 'saveNews'])->name('news.save')->middleware('auth');

Route::group(['controller' => FrontendPageController::class,], function () {

    Route::get('/trending', 'shorts')->name('trending');
    Route::post('/feedback', 'storeFeedback')->name('store.feedback');
});


Route::get('/load-more-news', [LoaderController::class, 'loadMoreNews']);
Route::get('/load-more-trending-news', [LoaderController::class, 'loadMoreTrendingNews']);

Route::get('/{id}/load-more-comments', function ($id, Request $request) {


    $news = News::find($id);
    $comments = $news->comments()->where('parent_id')->with('replies')->with('owner')->withCount('replies')->orderByDesc('id')->orderBy('score')->cursorPaginate(10, ['*'], 'cursor', $request->input('cursor'));
    return [
        'comments' => view('partials.comments', compact('comments'))->render(),
        'next_cursor' => optional($comments->nextCursor())->encode(),
    ];
});
Route::middleware('establish')->group(function () {

    Route::get('/', function (Request $request) {
        $page =  $request->input('page') ?? 1;
        $news = News::interested()->with('translations', 'images')->withCount('images', 'comments')->orderByDesc('processed_timestamp')->paginate(5, ['*'], 'interestedNews', $page);
        foreach ($news as $item) {
            $item->increment('display_count');
        }
        $categories = Category::all();
        return view('pages.home', compact('categories', 'news'));
    })->name('home');

    Auth::routes();

    Route::get('/set-interests', function () {
        return view('pages.interests');
    });

    Route::get('/donation', [DonationController::class, 'donatePageShow'])->name('donation');
    Route::get('/donation/thankyou', [DonationController::class, 'thankyou'])->name('donation.thankyou');
    Route::get('/donation/donate', [DonationController::class, 'donatePagePay'])->name('donation.donate');
    Route::post('/create-payment-intent', [DonationController::class, 'createPaymentIntent'])->name('donate.createPaymentIntent');
    Route::middleware('auth')->group(function () {
        Route::group(['controller' => ProfileController::class, 'prefix' => 'profile', 'as' => 'profile.'], function () {
            Route::get('/', 'viewProfile')->name('view');
            Route::get('/edit', 'showProfileForm')->name('edit');
            Route::post('/edit', 'updateProfile')->name('update');
            Route::get('/load-more-bookmarks', 'loadBookmarks');
            Route::get('/saved/news', 'savedNews')->name('saved.news');

            Route::get('set-location', function () {
                $locations = auth()->user()->locations;

                return view('pages.setlocation', compact('locations'));
            })->name('location.set');
            Route::post('set-location', function (Request $request) {
                if ($request->action == 'primary') {
                    auth()->user()->update([
                        'city' => $request->city,
                        'state' => $request->state,
                        'zip' => $request->zip,
                        'country' => $request->country,
                        'address' => $request->address,
                    ]);
                } else {
                    auth()->user()->locations()->create([
                        'city' => $request->city,
                        'state' => $request->state,
                        'country' => $request->country,
                        'zip' => $request->zip,
                        'address' => $request->address,
                    ]);
                }
                return redirect()->back()->with('success', 'Location updated');
            });
            Route::get('remove-location/{location}', function (Location $location) {
                if ($location->user_id != auth()->id())
                    abort(403);
                $location->delete();

                return redirect()->back()->with('success', 'Location removed');
            })->name('location.remove');
        });
        Route::group(['controller' => CommentController::class], function () {
            Route::post('{id}/comments/reply', 'reply')->name('news.comments.reply');
            Route::post('comment/vote/{comment}', 'commentVote')->name('news.comments.vote');
            Route::get('comment/save/{comment}', 'commentSave')->name('news.comments.save');
            Route::get('comment/report/{comment}', 'commentReport')->name('news.comments.report');
        });
    });

  
    

    Route::get('article/{news}', function (News $news) {
        $news->load('translations', 'images')->loadCount('images', 'comments');
        $news->increment('view_count');
        return view('pages.news', compact('news'));
    })->name('news.show');


    Route::get('article/{news}/comments', function (News $news) {

        return view('pages.comments', compact('news'));
    })->name('news.comments');
});
Route::get('{page}', [FrontendPageController::class, 'page'])->name('view.about');
