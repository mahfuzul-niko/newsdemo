<?php

namespace App\Helpers;

use App\Models\Category;

class System
{
    public static function getLocale()
    {
        if (auth()->check()) {
            return auth()->user()->getLocale();
        } elseif (request()->hasCookie('locale')) {
            return request()->cookie('locale');
        } else {
            return null;
        }
    }
    public static function getInterests()
    {
        if (auth()->check()) {
            return  auth()->user()->getInterests();
        } elseif (request()->hasCookie('interests')) {
            return json_decode(request()->cookie('interests'), 'true') ??  Category::all()->pluck('id')->toArray();
        } else {
            return Category::all()->pluck('id')->toArray();
        }
    }
    public static function getLocation()
    {
        if (auth()->check()) {
            return auth()->user()->getLocation();
        } elseif (request()->hasCookie('location')) {
            return json_decode(request()->cookie('location'), 'true');
        } else {
            return [
                'default' => true,
                'country' => 'United State',
                'state' => 'New York',
                'city' => 'New York',
                'zip' => 10001,
                'address' => '47 W 13th St, New York, NY 10011, USA',
            ];
        }
    }
}
