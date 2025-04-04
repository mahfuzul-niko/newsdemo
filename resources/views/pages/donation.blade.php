@extends('layouts.app')

@section('content')
    <main class="mobile-container">
        <header class="header d-flex align-items-center justify-content-between w-100">

            <h3 class="mx-auto special">Donate</h3>
        </header>


        <main id="news-container" style="margin-top: 50px;">
            <img style="height: 300px;width:100%;object-fit:cover" src="{{ asset('assets/donation-cover.jpg') }}"
                alt="Storytelling with Pictures: The Role of Photography in Journalism">
            <p class="text-center mt-3">
                Our mission from day one has been to ensure equal coverage across global stories while including all
                perspectives.
                <br>
                We believe that journalistic resources are the key to propel our mission.
                If you value fair, diverse coverage and wish to help us bring real stories to a wider audience in every
                corner of the world, please lend a helping hand. Even the smallest amount can help us in making a great
                difference.
                <br>
                All proceeds go toward our Journalist Fund, which allows journalists to pursue real leads to the fullest
                extent. Join us in our goal to give a voice to those who have been silenced, and uncover truths to bring to
                our readers.
                <br>
                <br>
                <a class="btn btn-primary" href="{{ route('donation.donate') }}">I'm in</a>
            </p>
        </main>

        @include('partials.navigation.bottom')
    </main>
@endsection
