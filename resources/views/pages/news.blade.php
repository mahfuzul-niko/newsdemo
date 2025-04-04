@extends('layouts.app')

@section('meta_title', $news->translate()->title)
@section('meta_description', $news->translate()->summary)
@section('meta_keyowrds', $news->keywords)

@section('og_title', $news->translate()->title)
@section('og_desc', $news->translate()->summary)
@section('og_url', route('news.show', $news))
@if ($news->images->count() > 0)
    @section('og_image', $news->images[0]->url)
@endif
@section('meta_keyowrds', $news->keywords)

@section('content')
    <main class="mobile-container">

        <header class="header d-flex align-items-center justify-content-between w-100">


            <button onclick="history.back()" class="btn-none"><i class="fa fa-chevron-left text-dark"></i></button>
            <h1 class="mx-auto special">
                News
            </h1>
        </header>
        <main id="news-container">
            <br>
            <br>
            @if ($news->images->count() > 0)
                <div id="newcarousel{{ $news->id }}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($news->images as $image)
                            <div class="carousel-item @if ($loop->first) active @endif">
                                <img data-src="{{ $image->url }}"
                                    src="{{ asset('assets/placeholder.jpg') }}"class="d-block w-100" loading="lazy"
                                    alt="...">
                            </div>
                        @endforeach

                    </div>
                    @if ($news->images->count() > 1)
                        <button class="carousel-control-prev" type="button"
                            data-bs-target="#newcarousel{{ $news->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button"
                            data-bs-target="#newcarousel{{ $news->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    @endif
                </div>
            @endif

            <h2>{{ $news->translate()->title }}</h2>
            @php
                $summary = $news->translate()->summary;

            @endphp

            <p class="full-summary">
                {{ $summary }}
            </p>

            <div class="d-flex justify-content-between">
                <div>
                    <small>{{ $news->created_at->diffForHumans() }}</small>
                </div>
                <div>
                    @auth

                        <a href="{{ route('news.save', ['id' => $news->id]) }}" style="font-size:1.2rem" class="btn-none">
                            @if (auth()->user()->savedNews->contains($news))
                                <i class="fa-solid fa-bookmark fs-normal"></i>
                            @else
                                <i class="fa-regular fa-bookmark"></i>
                            @endif
                        </a>
                    @endauth
                    <a href="{{ route('news.comments', ['news' => $news]) }}" class="btn-none" style="font-size:1.2rem">
                        <i class="fa-regular fa-comment"></i> <small>{{ $news->comments->count() }}</small>
                    </a>
                    <button class="btn-none" onclick="share(this)" style="font-size:1.2rem"
                        data-share="{{ route('news.share', ['id' => $news->id]) }}"
                        data-title="{{ $news->translate()->title }}"
                        data-url="{{ route('news.show', ['news' => $news]) }}">
                        <i class="fa fa-paper-plane"></i><small class="share-count">{{ $news->shares }}</small>
                    </button>
                </div>
            </div>
            <hr>
            <table class="table my-2 fs-small">
                @if ($news->comment_left)
                    <tr>
                        <th>
                            Comment left
                        </th>
                        <td>
                            {{ $news->comment_left ?? 'N/A' }}
                        </td>
                    </tr>
                @endif
                @if ($news->comment_neutral)
                    <tr>
                        <th>
                            Comment neutral
                        </th>
                        <td>
                            {{ $news->comment_neutral ?? 'N/A' }}
                        </td>
                    </tr>
                @endif
                @if ($news->comment_right)
                    <tr>
                        <th>
                            Comment right
                        </th>
                        <td>
                            {{ $news->comment_right ?? 'N/A' }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>
                        Media Bias
                    </th>
                    <td>
                        {{ $news->media_bias }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Website
                    </th>
                    <td>
                        <a href="{{ $news->url ?? '#' }}">{{ $news->url ?? 'Not available' }}</a>
                    </td>
                </tr>
                <tr>
                    <th>
                        Source
                    </th>
                    <td>
                        {{ $news->source ?? 'Not available' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Key figures
                    </th>
                    <td>
                        {{ $news->key_figures ?? 'Not available' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Keywords
                    </th>
                    <td>
                        {{ $news->keywords ?? 'Not available' }}
                    </td>
                </tr>
            </table>
            <br>
            <br>
        </main>

        @include('partials.navigation.bottom')
    </main>

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
@endsection
@section('js')
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

@endsection
@endsection
