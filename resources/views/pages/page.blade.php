@extends('layouts.app')

@section('content')
    <main class="mobile-container">
        <header class="header d-flex align-items-center w-100">
            <button onclick="history.back()" class="btn-none"><i class="fa fa-chevron-left text-dark"></i></button>
            <h3 class="mx-auto special">{{$page->title}}</h3>
        </header>
        <main class="d-flex align-items-center justify-content-center">
            <div class="mt-5">
                
                <div class="container mt-4">
                   {!! $page->content !!}
                </div>
            </div>

        </main>
        @include('partials.navigation.bottom')
    </main>

@section('css')
@endsection
@endsection
