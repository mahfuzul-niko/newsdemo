@extends('layouts.app')

@section('content')
    <main class="mobile-container">
        <header class="header d-flex align-items-center justify-content-between w-100"">
           
            <h1 class="mx-auto special ">
                Trending News
            </h1>
        </header>

        <main id="news-container" style="margin-top: 50px;">


            @include('partials.news', ['news' => $news])
        </main>

        <div id="loading" class=" justify-content-center align-items-center py-5" style="display:none;">
            <div class="dots-loader"></div>
        </div>

        <br>
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

            fetch(el.dataset.read)




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
        let page = "{{ request()->page }}";

        let loading = false;

        function loadMoreNews() {
            if (loading) return;
            loading = true;

            document.getElementById('loading').style.display = 'flex';

            fetch(`/load-more-trending-news?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('news-container').innerHTML += data.news;
                    page = data.next_page; // Update the cursor for the next request

                    prevPage = data.prev_page; // Update the cursor for the next request
                    loading = false;
                    history.pushState('', '', "{{ url()->current() }}?page=" + prevPage)
                    window.lazyLoad()
                    // Stop loading if no more results
                    if (!page) {
                        window.removeEventListener('scroll', onScroll);
                        document.getElementById('news-container').innerHTML +=
                            '<h3 class="text-center my-5"> <i class="fa fa-sad-tear"></i> Nothing found</h3>'
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
