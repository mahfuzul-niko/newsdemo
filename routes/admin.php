<?php

use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Models\News;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('admin/dashboard')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/comment/search', [AdminController::class, 'search'])->name('comment.search');
    Route::get('comments', [AdminController::class, 'commentIndex'])->name('comments.index');
    Route::patch('comments/{id}/status', [AdminController::class, 'commentUpdateStatus'])->name('comments.updateStatus');

    Route::get('/image/status', function () {
        $news = News::find(request()->id);
        $news->image_status = !$news->image_status;
        $news->save();
        return $news;
    })->name('image.status');
    
    Route::get('/news/status', function () {
        $news = News::find(request()->id);
        $news->status = !$news->status;
        $news->save();
        return $news;
    })->name('news.status');

    Route::resource('users', UserController::class);
    Route::resource('pages', PageController::class);
    Route::resource('news', NewsController::class);
    Route::resource('category', CategoryController::class)->except('show');
    Route::group(['controller' => UserController::class], function () {
        Route::get('/user/search', 'search')->name('user.search');
    });
    Route::group(['controller' => ProfileController::class, 'prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', 'index')->name('view');
    });
    Route::group(['controller' => ProfileController::class,], function () {
        Route::get('/feedback', 'feedback')->name('feedback');
        Route::post('/feedback', 'storeFeedback')->name('store.feedback');
    });
});
