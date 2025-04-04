<!-- resources/views/admin/comments/index.blade.php -->

@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Profile Management</h1>
        </div>
        <main class="d-flex flex-column justify-content-around " >
            <div>

                <div class="text-center mt-5">
                    <div class="profile-image position-relative">
                        <img src="{{ auth()->user()->getAvatar() }}" alt="" class="rounded-circle"
                            style="max-width: 200px;
                                    height: auto;">
                        <a href="{{ route('profile.edit') }}" class="btn-none" style="position: absolute;bottom:10px;"><i
                                class="fa fa-edit"></i></a>
                    </div>
                    <div class="mt-2">
                    </div>
                </div>
                <div class="container mt-5 text-center ">
                    <h3>{{ auth()->user()->username }}</h3>
                    <h5 class="fs-small text-secondary">{{ auth()->user()->email }}</h5>
                    <p class="fs-small text-secondary m-0">{{ auth()->user()->address }}</p>
                    <p class="text-secondary fs-small m-0">{{ auth()->user()->state }} , {{ auth()->user()->country }}</p>
                    <p class="mt-4 ">
                        {{ auth()->user()->bio }}
                    </p>
                </div>

            </div>
        </main>

    </div>
@endsection
