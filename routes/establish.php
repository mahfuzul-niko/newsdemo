<?php

use App\Helpers\System;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

Route::get('/pick/languages', function () {

    $first = false;

    if (auth()->check() || System::getLocale()) {
        $first = true;
    }
    return view('pages.establish.languages', compact('first'));
})->name('pick.locale');

Route::post('/pick/languages', function (Request $request) {
    if (auth()->check()) {
        auth()->user()->update([
            'locale' => $request->lang
        ]);
        return redirect()->route('profile.view')->with('success', 'Locale changed');
    } else {
        Cookie::queue('locale', $request->lang, 60 * 24 * 30);
        if (auth()->check() || request()->hasCookie('interests')) {

            return redirect()->route('home')->with('success', 'Language selected');
        } else {

            return redirect()->route('establish.pick.interests')->with('success', 'Language selected');
        }
    }
})->name('store.languages');

Route::get('/pick/interests', function () {

    $categories = Category::all();
    $first = false;
    if (auth()->check() || request()->hasCookie('interests')) {
        $first = true;
    }
    return view('pages.establish.interests', compact('categories', 'first'));
})->name('pick.interests');


Route::post('/pick/interests', function (Request $request) {
    if (auth()->check()) {
        auth()->user()->categories()->sync($request->interests);
        return redirect()->route('home')->with('success', 'Interests updated');
    } else {
        Cookie::queue('interests', json_encode($request->interests), 60 * 24 * 30);
        return redirect()->route('establish.pick.location');
    }
})->name('store.interests');


Route::get('/pick/location', function () {


    if (System::getLocation() && isset(System::getLocation()['default']) == false) {
        return redirect()->route('home');
    }

    return view('pages.establish.location');
})->name('pick.location');
Route::post('/pick/location', function (Request $request) {

    $request->validate([
        'country' => 'nullable|string|max:20',
        'state' => 'nullable|string|max:20',
        'city' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:100',
    ]);
    $data = [
        'country' => $request->country,
        'state' => $request->state,
        'city' => $request->city,
        'address' => $request->address,
    ];

    Cookie::queue('location', json_encode($data), 60 * 24 * 30);
    return redirect()->route('home');
})->name('store.location');
