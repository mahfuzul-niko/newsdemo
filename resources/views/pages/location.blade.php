@extends('layouts.app')

@section('content')

    <main class="mobile-container">
        <header class="header d-flex align-items-center w-100">
            <button onclick="history.back()"
                class="btn-none"><i class="fa fa-chevron-left text-dark"></i></button>
            <i class="fa-regular fa-comments fa-2x mx-auto d-block w-50 d-flex justify-content-center"></i>
        </header>

        <main id="comments-container" style="margin-top: 50px;">

        </main>

        <div id="loading" style="display:none;">
            <p>Loading more comments...</p>
        </div>

        <br>
        <br>
        <br>
        <button class="btn btn-custom-dark rounded-circle d-flex align-items-center justify-content-center"
            style="height: 50px;width:50px;position: fixed;bottom:10px;right:20px;" data-bs-toggle="offcanvas"
            data-bs-target="#commentOffcanvas" aria-controls="commentOffcanvas"><i
                class="fa-regular fa-plus fa-2x"></i></button>
    </main>

    <div class="offcanvas offcanvas-bottom " data-bs-backdrop="static" tabindex="-1" id="commentOffcanvas" aria-labelledby="commentOffcanvasLabel">
        <div class="offcanvas-header ">
            <h5 class="offcanvas-title" id="commentOffcanvasLabel">Comment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        @auth
            <div class="offcanvas-body">
                <form action="{{ route('news.comments.reply', $news) }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent" id="parent_cmnt_input" value="">
                    <div class="mb-3">
                        <textarea name="comment" class="form-control" id="comment" cols="30" rows="10" required></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-custom-dark py-2"><i class="fa fa-paper-plane"></i> Reply</button>
                    </div>

                </form>
            </div>
        @else
            <div class="offcanvas-body">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <p class="fs-5">Please <a href="{{ route('login') }}">Sign in</a> to comment</p>
                </div>
            </div>
        @endauth
    </div>

    {{-- @section('css')
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
@endsection --}}
@section('js')
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        let cursor = null;
        let loading = false;

        function loadMoreComments() {
            if (loading) return;
            loading = true;

            document.getElementById('loading').style.display = 'block';

            fetch(`/{{ $news->getRouteKey() }}/load-more-comments?cursor=${cursor}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('comments-container').innerHTML += data.comments;
                    cursor = data.next_cursor; // Update the cursor for the next request
                    loading = false;

                    // Stop loading if no more results
                    if (!cursor) {
                        window.removeEventListener('scroll', onScroll);
                    }
                })
                .catch(error => {
                    console.error('Error loading more news:', error);
                    loading = false;
                });
        }


        loadMoreComments();

        function onScroll() {

            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 500) {
                loadMoreComments();
            }
        }

        window.addEventListener('scroll', onScroll);
    </script>
    <script>
        const myOffcanvas = document.getElementById('commentOffcanvas')
        myOffcanvas.addEventListener('show.bs.offcanvas', event => {

            document.getElementById('parent_cmnt_input').value = event.explicitOriginalTarget.dataset.id ?? null;
        })
        const toggleReplies = (el) => {

            if (el.classList.contains('active')) {
                el.classList.remove('active');
            } else {
                el.classList.add('active');

            }
            const targetId = el.id;
            const repliesContainer = document.querySelector(
                `.replies-container[data-id="${targetId}"]`);

            if (repliesContainer) {
                if (repliesContainer.style.display === 'none' || repliesContainer.style
                    .display === '') {
                    repliesContainer.style.display = 'block';
                } else {
                    repliesContainer.style.display = 'none';
                }
            }
        };
    </script>
@endsection
@endsection
