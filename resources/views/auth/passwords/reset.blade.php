

@extends('layouts.app')

@section('content')
    <main class="mobile-container d-flex flex-column w-auto justify-content-center align-items-center vh-100">
        <img class="logo mb-5" src="{{ asset('assets/logo.jpg') }}" alt="">
        <div class="row w-100">
       
                    <h1 class="h2">{{ __('Reset Password') }} </h1>

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="token" value="{{ $token }}">

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
                         
                            <div class="d-grid mt-2">
                                <button type="submit" class="btn btn-custom-dark rounded-border py-3">   {{ __('Reset Password') }}</button>
                            </div>
                        </div>
                    </form>
            
       

        </div>

        </div>
      
    </main>
@endsection
