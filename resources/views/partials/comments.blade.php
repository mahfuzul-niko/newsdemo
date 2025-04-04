@foreach ($comments as $comment)
    <div class="p-2 mt-2" style="border-left: 1px dashed #0000009c; border-bottom: 1px dashed #0000009c;border-radius:5px">
        <div class="article d-flex gap-2 " style="border: none!important;">
            <img src="{{ $comment->owner->getAvatar() }}"  style="height: 40px;width:40px;border-radius:50%" alt="">
            <div>
                <div>
                    <strong class="fs-small">{{ $comment->owner->name }}</strong>
                    <p class="fs-small">{{ $comment->owner->country }}, {{ $comment->created_at->diffForHumans() }}</p>
                </div>
                <div>
                    <p>{{ $comment->translate()->comment }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <div>
                        <button class="btn btn-none fs-small" data-id="{{ $comment->id }}" data-bs-toggle="offcanvas"
                            data-bs-target="#commentOffcanvas" aria-controls="commentOffcanvas"><i
                                class="fa-regular fa-comment"></i> Reply</button>
                        <form class="d-inline" action="{{ route('news.comments.vote', $comment) }}" method="post">
                            @csrf
                            <input type="hidden" value="1" name="vote_type">

                            <button
                                class="btn btn-none fs-small {{auth()->check() && auth()->user()?->upvotes()->find($comment) ? 'text-info' : '' }}"><i
                                    class="fa fa-arrow-up"></i>
                                &nbsp;{{ $comment->upvotes_count }}</button>

                        </form>
                        <form class="d-inline" action="{{ route('news.comments.vote', $comment) }}" method="post">
                            @csrf
                            <input type="hidden" value="0" name="vote_type">
                            <button class="btn btn-none fs-small {{ auth()->check() && auth()->user()?->downvotes()->find($comment) ? 'text-info' : '' }}"><i class="fa fa-arrow-down"></i>
                                &nbsp;{{ $comment->downvotes_count }}</button>
                        </form>
                        <button class="btn btn-none fs-small toggle-replies" onclick="toggleReplies(this)"
                            id="repliesOf{{ $comment->id }}">
                            {{ $comment->replies->count() }} comments
                        </button>
                    </div>
                    <div class="">
                        <button data-bs-toggle="modal" {{ auth()->check() && auth()->user()?->reportsaves()->find($comment) ? "data-bs-reported=true" : "data-bs-reported=false" }}  {{ auth()->check() && auth()->user()?->commentsaves()->find($comment) ? "data-bs-saved=true" : "data-bs-saved=false" }} data-bs-saveurl="{{route('news.comments.save',$comment)}}" data-bs-reporturl="{{route('news.comments.report',$comment)}}" data-bs-target="#commentModal" class="btn btn-none fs-small"><i class="fa-solid fa-ellipsis"></i></button>
                    </div>
                </div>
            </div>

        </div>
 
        <div class="replies-container"  data-id="repliesOf{{ $comment->id }}" style="display: none;">
            @include('partials.comments', ['comments' => $comment->replies])
        </div>
    </div>
@endforeach
