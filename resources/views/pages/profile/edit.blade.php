@extends('layouts.app')
@section('meta_robots', 'noindex')

@section('content')
    <main class="mobile-container">
        @include('partials.navigation.top')
        <main class="d-flex flex-column justify-content-around mt-5">
            <div>
                <section class="text-center">
                    <livewire:image-upload />

                </section>
                <section class="container mt-4 px-5">
                    <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                        @csrf


                        <div class="form-floating mb-3 fs-medium">
                            <input type="text" class="form-control" id="floatingInput" value="{{ auth()->user()->name }}"
                                name="name" placeholder="">
                            <label for="floatingInput">Name</label>
                        </div>
                        <div class="form-floating mb-3 fs-medium">
                            <input type="text" class="form-control" id="floatingInput"
                                value="{{ auth()->user()->username }}" name="username" placeholder="">
                            <label for="floatingInput">User Name</label>
                        </div>
                        <div class="form-floating mb-3 fs-medium">
                            <input type="text" class="form-control" id="floatingInput"
                                value="{{ auth()->user()->website }}" name="website" placeholder="">
                            <label for="floatingInput">Website</label>
                        </div>
                        <div class="form-floating mb-3 fs-medium">
                            <input type="text" class="form-control" name="bio" id="floatingInput"
                                value="{{ auth()->user()->bio }}" placeholder="">
                            <label for="floatingInput">Bio</label>
                        </div>
                        <p>Private info (only visible to you)</p>
                        <div class="form-floating mb-3 fs-medium">
                            <input type="email" readonly disabled class="form-control" id="floatingInput"
                                value="{{ auth()->user()->email }}" placeholder="">
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary py-3 " style="border-radius: 20px">Submit</button>
                        </div>

                    </form>
                </section>
            </div>

        </main>
        @include('partials.navigation.bottom')
    </main>

@section('css')
    @livewireStyles
@endsection
@section('js')
    @livewireScripts
@endsection
@endsection
