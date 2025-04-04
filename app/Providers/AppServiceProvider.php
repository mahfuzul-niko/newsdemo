<?php

namespace App\Providers;

use App\Facades\System;
use App\Facades\SystemFacade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

use Lcobucci\JWT\Configuration;

use Lcobucci\JWT\Signer\Ecdsa\Sha256;

use Lcobucci\JWT\Signer\Key\InMemory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind('system', function () {
            return new \App\Helpers\System();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') == 'production') {
            URL::forceScheme('https');
        }

        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('google', \SocialiteProviders\Google\Provider::class);
        });

        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('apple', \SocialiteProviders\Apple\Provider::class);
        });
        

        $this->app->bind(Configuration::class, fn () => Configuration::forSymmetricSigner(

            Sha256::create(),
    
            InMemory::plainText(config('services.apple.private_key')),
    
        ));
    }
}
