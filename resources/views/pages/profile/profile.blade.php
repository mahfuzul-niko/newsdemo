@extends('layouts.app')

@section('meta_robots', 'noindex')

@section('content')
    <main class="mobile-container">

        @include('partials.navigation.top', ['back'=>false])
        <main class="d-flex flex-column justify-content-around " style="height: 80vh">
            <div>

                <div class="text-center">
                    <div class="profile-image position-relative">
                        <img src="{{ auth()->user()->getAvatar() }}" alt="" class="avatar-xl rounded-circle">
                        <a href="{{ route('profile.edit') }}" class="btn-none" style="position: absolute;bottom:10px;"><i
                                class="fa fa-edit"></i></a>
                    </div>
                    <div class="mt-2">
                    </div>
                </div>
                <div class="container mt-5">
                    <h3>{{ auth()->user()->username }}</h3>
                    <h5 class="fs-small text-secondary">{{ auth()->user()->email }}</h5>
                    <p class="fs-small text-secondary m-0">{{ auth()->user()->address }}</p>
                    <p class="text-secondary fs-small m-0">{{ auth()->user()->state }} , {{ auth()->user()->country }}</p>
                    <p class="mt-4 ">
                        {{ auth()->user()->bio }}
                    </p>
                </div>

            </div>
            <div>
                <ul class="list-group">
                    <li class="list-group-item px-5">
                        <a href="{{ route('profile.saved.news') }}" class="btn-none">
                            <i class="fa-regular fa-bookmark"></i>  Saved
                        </a>
                    </li>
                </ul>
            </div>
        </main>
    </main>
    @include('partials.navigation.bottom')

@section('css')
@endsection
@endsection
