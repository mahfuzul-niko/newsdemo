<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\System;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AppleToken;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            true
        );
    }


    public function socialLoginCallback(Request $request, $provider)
    {
        switch ($provider) {
            case 'google':
                $this->loginWithGoogle();
                break;
            case 'facebook':
                $this->loginWithFacebook();

                break;
            case 'apple':

                $this->loginWithApple();
                break;
        }

        return redirect()->route('home');
    }

    protected function loginWithGoogle()
    {
        try {
            $data = Socialite::driver('google')->user();
            $user = User::updateOrCreate([
                'email' => $data->email,
            ], [
                'name' => $data->name ?? $data->email,
                'username' => $data->nickname ?? $data->email,
                'avatar' => $data->avatar,
            ]);
            if ($user->wasRecentlyCreated) {
                $user->update([
                    'country' => @System::getLocation()['country'],
                    'state' => @System::getLocation()['state'],
                    'city' => @System::getLocation()['city'],
                    'zip' => @System::getLocation()['zip'],
                    'address' => @System::getLocation()['address'],
                    'locale' => @System::getLocale(),
                ]);
                $user->categories()->sync(System::getInterests());
            }
            Auth::login($user);
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors('Google login failed. Please try again.');
        }
    }

    protected function loginWithFacebook()
    {
        try {
            $data = Socialite::driver('facebook')->user();
            $user = User::updateOrCreate([
                'email' => $data->email,
            ], [
                'name' => $data->name,
                'username' => $data->name,
                'avatar' => $data->avatar,
            ]);
            if ($user->wasRecentlyCreated) {
                $user->update([
                    'country' => @System::getLocation()['country'],
                    'state' => @System::getLocation()['state'],
                    'city' => @System::getLocation()['city'],
                    'zip' => @System::getLocation()['zip'],
                    'address' => @System::getLocation()['address'],
                    'locale' => @System::getLocale(),
                ]);
                $user->categories()->sync(System::getInterests());
            }
            Auth::login($user);
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors('Facebook login failed. Please try again.');
        }
    }

    protected function loginWithApple(AppleToken $appleToken)
    {
        try {
            config()->set('services.apple.client_secret', $appleToken->generate());
            $data = Socialite::driver('apple')->user();
            $user = User::updateOrCreate([
                'email' => $data->email,
            ], [
                'name' => $data->name,
                'username' => $data->name,
                'avatar' => $data->avatar,
            ]);
            if ($user->wasRecentlyCreated) {
                $user->update([
                    'country' => @System::getLocation()['country'],
                    'state' => @System::getLocation()['state'],
                    'city' => @System::getLocation()['city'],
                    'zip' => @System::getLocation()['zip'],
                    'address' => @System::getLocation()['address'],
                    'locale' => @System::getLocale(),
                ]);
                $user->categories()->sync(System::getInterests());
            }
            Auth::login($user);
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors('Facebook login failed. Please try again.');
        }
    }


    public function socialLogin($provider)
    {

        switch ($provider) {
            case 'google':
                return Socialite::driver('google')->redirect();
                break;
            case 'facebook':
                return Socialite::driver('facebook')->redirect();
                break;
            case 'apple':

                return Socialite::driver('apple')->redirect();

                break;
        }
    }
}
