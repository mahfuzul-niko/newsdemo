@extends('layouts.app')

@section('content')
    <main class="mobile-container d-flex flex-column w-auto justify-content-center align-items-center vh-100">
        <img src="{{ asset('assets/verifyEmail.png') }}" style="height: 100px;width:100px" alt="">
        <h2>Verify your email address</h2>
        <p class="text-center text-secondary">We’ve sent an email to <br> <strong>user@userserver.com</strong> to verify your
            email <br> address and activate your account.</p>

        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit"
                class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
        </form>
    </main>
@endsection
