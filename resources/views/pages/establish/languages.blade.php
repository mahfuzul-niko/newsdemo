@extends('layouts.app')

@section('content')
    <form action="{{ route('establish.store.languages') }}" method="post">

        @csrf
        <main class="mobile-container d-flex flex-column w-auto justify-content-center align-items-center vh-100">
            <img class="logo mb-3" src="{{ asset('assets/logo.jpg') }}" alt="">
            <div class="row">
                <div class="col-12 d-flex flex-column w-auto gap-3">
                    <div class="d-grid text-center">
                        <input type="radio" name="lang" value="en" @if (App\Helpers\System::getLocale() == 'en') checked @endif
                            class="btn-check " id="btn-check-en">
                        <label class="py-3 btn-custom-light" for="btn-check-en">English</label>
                    </div>
                    <div class="d-grid text-center">
                        <input type="radio" name="lang" @if (App\Helpers\System::getLocale() == 'cn') checked @endif value="cn"
                            class="btn-check " id="btn-check-cn">
                        <label class="py-3 btn-custom-light " for="btn-check-cn">中文</label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">

                @if ($first)
                    <a href="{{ url('/') }}" class="btn-none mt-5 fs-small text-center" id="">
                        {{ __('Home') }} </a>
                @endif
                <button type="submit" class="btn-none mt-5 fs-small text-center" id="submitBtn"> {{ __('Next') }}
                </button>
            </div>
        </main>
    </form>
@endsection
