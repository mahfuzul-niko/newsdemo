<?php

namespace App\Http\Middleware;

use App\Helpers\System;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocationSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (System::getLocation()) {
            return $next($request);
        } else {
            return redirect()->route('establish.pick.location');
        }
    }
}
