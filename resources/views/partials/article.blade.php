<article class="article" data-aos="zoom-in-up">
    @if ($post->images_count > 0)
        <div id="newcarousel{{ $post->id }}" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($post->images as $image)
                    <div class="carousel-item @if ($loop->first) active @endif">
                        <img loading="lazy" data-src="{{ $image->url }}" src="{{ asset('assets/placeholder.jpg') }}"
                            class="d-block w-100" alt="...">
                    </div>
                @endforeach

            </div>
            @if ($post->images_count > 1)
                <button class="carousel-control-prev" type="button"
                    data-bs-target="#newcarousel{{ $post->id }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button"
                    data-bs-target="#newcarousel{{ $post->id }}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            @endif
        </div>
    @endif
    <a href="{{ route('news.show', ['news' => $post]) }}">
        <h2>{{ $post->translate()->title }}</h2>
    </a>
    @php
        $summary = $post->translate()->summary;
        $truncated = Str::limit($summary, 200); // Limit to 100 characters
    @endphp
    <p class="article-summary">
        {{ $truncated }}
        @if (strlen($summary) > 200)
            <span class="see-more text-secondary" style="cursor: pointer;"
                data-read="{{ route('news.read', ['id' => $post->id]) }}" onclick="exapand(this)">more</span>
        @endif
    </p>

    <p class="full-summary" style="display: none;">
        {{ $summary }}
        <span class="see-less text-secondary" style="cursor: pointer;" onclick="contract(this)"> less</span>
    </p>
    <div class="article-footer">
        <div>
            <small>{{ $post->created_at->diffForHumans() }}</small>
        </div>
        <div>
            @auth

                <button data-saved="{{ auth()->user()->savedNews->contains($post) ? 'true' : 'false' }}"
                    onclick="bookmark(this)" data-save="{{ route('news.save', ['id' => $post->id]) }}"
                    style="font-size:1.2rem" class="btn-none">
                    @if (auth()->user()->savedNews->contains($post))
                        <i class="fa-solid fa-bookmark fs-normal"></i>
                    @else
                        <i class="fa-regular fa-bookmark"></i>
                    @endif
                    </button>
                @endauth
                <a href="{{ route('news.comments', ['news' => $post]) }}" class="btn-none"
                    style="font-size:1.2rem">
                    <i class="fa-regular fa-comment"></i> <small>{{ $post->comments_count }}</small>
                </a>
                <button class="btn-none" onclick="share(this)" style="font-size:1.2rem"
                    data-share="{{ route('news.share', ['id' => $post->id]) }}"
                    data-title="{{ $post->translate()->title }}"
                    data-url="{{ route('news.show', ['news' => $post]) }}">
                    <i class="fa fa-paper-plane"></i> <small class="share-count">{{ $post->shares }}</small>
                </button>
        </div>
    </div>
</article>