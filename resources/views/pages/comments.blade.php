@extends('layouts.app')


@section('meta_title', 'Comments|' . $news->translate()->title)
@section('meta_description', $news->translate()->summary)
@section('meta_keyowrds', $news->keywords)

@section('og_title', 'Comments|' . $news->translate()->title)
@section('og_desc', $news->translate()->summary)
@section('og_url', route('news.show', $news))
@if ($news->images->count() > 0)
    @section('og_image', $news->images[0]->url)
@endif
@section('meta_keyowrds', $news->keywords)


@section('content')

    <main class="mobile-container">
        <header class="header d-flex align-items-center w-100">
            <button onclick="history.back()" class="btn-none"><i class="fa fa-chevron-left text-dark"></i></button>
            <i class="fa-regular fa-comments fa-2x mx-auto d-block w-50 d-flex justify-content-center"></i>
        </header>

        <main id="comments-container" style="margin-top: 50px;">

        </main>

        <div id="loading" class="justify-content-center align-items-center py-5" style="display:none;">
            <div class="dots-loader"></div>
        </div>

        <br>
        <br>
        <br>
        <button class="btn btn-custom-dark rounded-circle d-flex align-items-center justify-content-center"
            style="height: 50px;width:50px;position: fixed;bottom:80px;right:20px;" data-bs-toggle="offcanvas"
            data-bs-target="#commentOffcanvas" aria-controls="commentOffcanvas"><i
                class="fa-regular fa-plus fa-2x"></i></button>

        <br>
        @include('partials.navigation.bottom')
    </main>

    <div class="offcanvas offcanvas-bottom " data-bs-backdrop="static" tabindex="-1" id="commentOffcanvas"
        aria-labelledby="commentOffcanvasLabel">
        <div class="offcanvas-header ">
            <h5 class="offcanvas-title" id="commentOffcanvasLabel">Comment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        @auth
            <div class="offcanvas-body">
                <form action="{{ route('news.comments.reply', $news->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="parent" id="parent_cmnt_input" value="">
                    <div class="mb-3">
                        <textarea name="comment" class="form-control" id="comment" cols="30" rows="10" required></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-custom-dark py-3 px-4"><i class="fa fa-paper-plane"></i>
                            Reply</button>
                    </div>

                </form>
            </div>
        @else
            <div class="offcanvas-body">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <p class="fs-5">Please <a class="text-primary" href="{{ route('login') }}">Sign in</a> to comment</p>
                </div>
            </div>
        @endauth
    </div>



    <!-- Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="commentModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">




                </div>

            </div>
        </div>
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
        let cursor = "";
        let loading = false;

        function loadMoreComments() {
            if (loading) return;
            loading = true;

            document.getElementById('loading').style.display = 'flex';

            fetch(`/{{ $news->id }}/load-more-comments?cursor=${cursor}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('comments-container').innerHTML += data.comments;
                    cursor = data.next_cursor; // Update the cursor for the next request
                    loading = false;
                    document.getElementById('loading').style.display = 'none';

                    document.querySelectorAll('.toggle-replies').forEach((el) => {
                        const targetId = el.id;
                        const state = localStorage.getItem(targetId); // Get the saved state

                        if (state === 'open') {
                            el.classList.add('active');
                            const repliesContainer = document.querySelector(
                                `.replies-container[data-id="${targetId}"]`);
                            if (repliesContainer) {
                                repliesContainer.style.display = 'block';
                            }
                        }
                    });
                    // Stop loading if no more results
                    if (!cursor) {
                        // document.getElementById('comments-container').innerHTML +=
                        //     '<br><br><h3 class="text-center my-5"> <i class="fa fa-sad-tear"></i> Nothing found</h3>';
                        window.removeEventListener('scroll', onScroll);
                    }
                })
                .catch(error => {
                    console.error('Error loading more news:', error);
                    loading = false;
                    document.getElementById('loading').style.display = 'none';

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
            const targetId = el.id;
            const repliesContainer = document.querySelector(`.replies-container[data-id="${targetId}"]`);

            if (el.classList.contains('active')) {
                el.classList.remove('active');
                localStorage.setItem(targetId, 'closed'); // Store the state as closed
            } else {
                el.classList.add('active');
                localStorage.setItem(targetId, 'open'); // Store the state as open
            }

            if (repliesContainer) {
                if (repliesContainer.style.display === 'none' || repliesContainer.style.display === '') {
                    repliesContainer.style.display = 'block';
                } else {
                    repliesContainer.style.display = 'none';
                }
            }
        };
    </script>
    <script>
        const commentModal = document.getElementById('commentModal')
        if (commentModal) {
            commentModal.addEventListener('show.bs.modal', event => {

                const button = event.relatedTarget

                const body = commentModal.querySelector('.modal-body')

                body.innerHTML = `  <div class="d-flex flex-column ">
        <a href="#" type="submit" class="btn-custom-light py-3 mb-3 saveCmntBtn"><i class="fa-solid fa-bookmark"></i>
            Save</a>
    </div>



    <div class="d-flex flex-column ">
        <a href="#" type="submit" class="btn-custom-dark py-3 reportCmntBtn"><i class="fa-solid fa-circle-exclamation"></i>
            Report</a>
    </div>`
                const saveurl = button.getAttribute('data-bs-saveurl')
                const reporturl = button.getAttribute('data-bs-reporturl')
                const saved = button.getAttribute('data-bs-saved')
                const reported = button.getAttribute('data-bs-reported')

                // Update the modal's content.
                const saveBtn = commentModal.querySelector('.saveCmntBtn')
                const reportBtn = commentModal.querySelector('.reportCmntBtn')


                if (saved == 'true') {
                    saveBtn.classList.remove('btn-custom-light');
                    saveBtn.classList.add('btn-primary');
                    saveBtn.classList.add('btn');
                    saveBtn.innerHTML = "<i class='fa-solid fa-bookmark'></i> Saved";
                }

                if (reported == 'true') {
                    reportBtn.classList.remove('btn-custom-dark');
                    reportBtn.classList.add('btn-danger');
                    reportBtn.classList.add('btn');
                    reportBtn.innerHTML = "<i class='fa-solid fa-circle-exclamation'></i> Reported";
                }
                saveBtn.href = saveurl;
                reportBtn.href = reporturl;

            })
        }
    </script>
@endsection
@endsection
