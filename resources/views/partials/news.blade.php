@foreach ($news as $post)
    @include('partials.article', ['post' => $post])
@endforeach
