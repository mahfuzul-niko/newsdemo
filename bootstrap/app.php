<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CategorySelected;
use App\Http\Middleware\LanguageIsSelected;
use App\Http\Middleware\LanguageSelected;
use App\Http\Middleware\LocationSelected;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')->name('establish.')->group(base_path('routes/establish.php'));
            Route::middleware(['web', 'auth', AdminMiddleware::class])->name('admin.')->group(base_path('routes/admin.php')); // Updated middleware usage
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('establish', [
            LanguageSelected::class,
            CategorySelected::class,
            LocationSelected::class,

        ])->trustProxies(at: ['*']);
 
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
