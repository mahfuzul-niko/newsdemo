@extends('layouts.app')

@section('content')
    <main class="mobile-container d-flex flex-column w-auto justify-content-center align-items-center vh-100">
        <a href="{{ route('home') }}"><img class="logo mb-5" src="{{ asset('assets/logo.jpg') }}" alt=""></a>
        <div class="row w-100">
            @if (request()->filled('email'))
                @php
                    $user = App\Models\User::where('email', request()->email)->first();
                @endphp
                @if ($user)
                    <h1 class="h2">Welcome back!</h1>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mt-5 px-3">
                            <input type="hidden" name="email" value="{{ request()->email }}">
                            <div class="form-floating mb-3 fs-medium">
                                <input type="password" class="form-control" id="floatingInput" name="password">
                                <label for="floatingInput">Password</label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-custom-dark rounded-border py-3">Continue</button>
                            </div>
                        </div>
                    </form>
                    <div class="mt-4">
                        <form action="{{ route('password.email') }}" method="post">
                            @csrf
                            <input type="hidden" name="email" value="{{ request()->email }}">
                            <button class="btn-none text-secondary fs-small">Forgot password</button>
                        </form>

                    </div>
                @else
                    <h1 class="h2">Finish signing up </h1>

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mt-5 px-3">
                            <div class="form-floating mb-3 fs-medium">
                                <input type="email" class="form-control  @error('email') is-invalid @enderror"
                                    value="{{ request()->email }}" id="floatingInput" placeholder="name@example.com"
                                    name="email">
                                <label for="floatingInput">Email</label>

                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3 fs-medium">
                                <input type="text" name="username"
                                    class="form-control @error('username') is-invalid @enderror" id="floatingInput">
                                <label for="floatingInput">Username</label>
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3 fs-medium">
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" id="floatingInput">
                                <label for="floatingInput">Password</label>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3 fs-medium">
                                <input type="password" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="floatingInput">
                                <label for="floatingInput">Confirm Password</label>
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <span class="fs-tiny text-secondary ">By continuing, you agree to our <a href="">Terms of
                                    Use</a> and <a href="">Privacy Policy</a> .</span>
                            <div class="d-grid mt-2">
                                <button type="submit" class="btn btn-custom-dark rounded-border py-3">Agree and
                                    continue</button>
                            </div>
                        </div>
                    </form>
                @endif
            @else
                <h1 class="h2">Log in or sign up with email</h1>
                <form action="{{ route('login') }}" method="get">
                    <div class="col-12 text-left">
                        <div class="mt-5 px-3">
                            <div class="form-floating mb-3 fs-medium">
                                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="">
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-custom-dark rounded-border py-3">Continue</button>
                            </div>
                        </div>
                </form>
            @endif

        </div>

        </div>
        <p class="text-center my-3">
            Or
        </p>
        <div class="row w-100 ">
            <div class="col-12 d-flex flex-column gap-4">
                <a href="{{ route('auth.social', ['provider' => 'facebook']) }}"
                    class="btn-custom-light p-3 w-100 text-center fs-large"><i class="fab fa-facebook fa-1x"></i>&nbsp;
                    Continue with Facebook</a>
                <a href="{{ route('auth.social', ['provider' => 'google']) }}"
                    class="btn-custom-light p-3 w-100 text-center fs-large"><i class="fab fa-google fa-1x"></i>&nbsp;
                    Continue with Google</a>
                <a href="{{ route('auth.social', ['provider' => 'apple']) }}" class="btn-custom-light p-3 w-100 text-center fs-large"><i
                        class="fab fa-apple fa-1x"></i>&nbsp; Continue with Apple</a>

            </div>
        </div>
        <a class="btn-none mt-5 fs-small" href="{{url('/')}}">Not now</a>
    </main>
@endsection
