@extends('layouts.app')

@section('content')
    <main class="mobile-container d-flex flex-column w-auto justify-content-center align-items-center vh-100">
        <img class="logo mb-5" src="{{ asset('assets/logo.jpg') }}" alt="">
        <div class="row w-100">
            <div class="col-12 text-left">
                <h1>Log in or sign up</h1>
                <p>
                    Create an account to save articles, preferences, and upload your own articles.
                </p>
                <span class="fs-tiny text-secondary">By continuing, you agree to our <a href="">Terms of Use</a> and <a
                        href="">Privacy Policy</a> .</span>
            </div>

        </div>
        <div class="row w-100 mt-4">
            <div class="col-12 d-flex flex-column gap-4">
                <a href="#" class="btn-custom-light p-3 w-100 text-center fs-large"><i
                        class="fab fa-facebook fa-1x"></i>&nbsp; Continue with Facebook</a>
                <a href="#" class="btn-custom-light p-3 w-100 text-center fs-large"><i
                        class="fab fa-google fa-1x"></i>&nbsp; Continue with Google</a>
                <a href="#" class="btn-custom-light p-3 w-100 text-center fs-large"><i
                        class="fab fa-apple fa-1x"></i>&nbsp; Continue with Apple</a>
                <a href="{{ route('login') }}" class="btn-custom-light p-3 w-100 text-center fs-large"><i
                        class="fa fa-envelope fa-1x"></i>&nbsp; Continue with Email</a>
            </div>
        </div>
        <a class="btn-none mt-5 fs-small" href="{{ url('/') }}">Not now</a>
    </main>
@endsection
