@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-dark">{{ $news->translate()->title }} </h2>
        </div>
        <article class="article container" data-aos="zoom-in-up">

            <div class="d-flex justify-content-center mb-3">
                <div class="col-md-8">
                    @if ($news->images->count() > 0)
                    <div id="newcarousel{{ $news->id }}" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($news->images as $image)
                                <div class="carousel-item @if ($loop->first) active @endif">
                                    <img src="{{ $image->url }}" class="d-block w-100" alt="...">
                                </div>
                            @endforeach

                        </div>
                        @if ($news->images->count() > 1)
                            <button class="carousel-control-prev" type="button"
                                data-target="#newcarousel{{ $news->id }}" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-target="#newcarousel{{ $news->id }}" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                @endif
                </div>
            </div>
            
            @php
                $summary = $news->translate()->summary;

            @endphp

            <p class="full-summary">
                {{ $summary }}
            </p>
            <div class="article-footer">

            </div>
        </article>

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
            <tr>
                <th>
                    Credibility Score
                </th>
                <td>
                    {{ $news->credibility_score ?? 'Not available' }}
                </td>
            </tr>
            <tr>
                <th>
                    Importance Score
                </th>
                <td>
                    {{ $news->importance_score ?? 'Not available' }}
                </td>
            </tr>
            <tr>
                <th>
                    Timeliness Score
                </th>
                <td>
                    {{ $news->timeliness_score ?? 'Not available' }}
                </td>
            </tr>
            <tr>
                <th>
                    Processed Timestamp
                </th>
                <td>
                    {{ $news->processed_timestamp ?? 'Not available' }}
                </td>
            </tr>
        </table>
    </div>
@endsection
