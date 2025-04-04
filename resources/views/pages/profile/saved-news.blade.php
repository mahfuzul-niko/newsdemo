@extends('layouts.app')
@section('meta_robots', 'noindex')
@section('content')
    <main class="mobile-container">
        @include('partials.navigation.top')

        <main id="news-container" style="margin-top: 50px;">
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
    <script>
        function exapand(el) {


            const article = el.closest('.article');
            const summary = article.querySelector('.article-summary');
            const fullSummary = article.querySelector('.full-summary');

            summary.style.display = 'none';
            fullSummary.style.display = 'block';




        }

        function contract(el) {

            const article = el.closest('.article');
            const summary = article.querySelector('.article-summary');
            const fullSummary = article.querySelector('.full-summary');

            summary.style.display = 'block';
            fullSummary.style.display = 'none';

        }
    </script>
    <script>
        let cursor = "{{ request()->cursor }}";

        let loading = false;

        function loadMoreNews() {
            if (loading) return;
            loading = true;


            fetch(`/profile/load-more-bookmarks?cursor=${cursor}`)
                .then(response => response.json())
                .then(data => {
                    if (data.empty) {
                        document.getElementById('news-container').innerHTML +=
                            '<h3 class="text-center my-5"> <i class="fa fa-sad-tear"></i> Nothing found</h3>'
                    } else {
                        document.getElementById('news-container').innerHTML += data.news;
                    }
                    cursor = data.next_cursor; // Update the cursor for the next request
                    prevCursor = data.prev_cursor; // Update the cursor for the next request
                    loading = false;
                    window.lazyLoad()
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


        loadMoreNews();



        function onScroll() {

            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 500) {
                loadMoreNews();
            }

        }

        window.addEventListener('scroll', onScroll);
    </script>
@endsection
@endsection
