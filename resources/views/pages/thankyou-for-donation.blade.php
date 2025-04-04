@extends('layouts.app')

@section('content')
    <main class="mobile-container d-flex flex-column w-auto justify-content-center align-items-center vh-100 px-4">
        <div>
            <i class="fas fa-smile-wink fa-4x"></i>
        </div>

        <h3 class="mt-4">Thank You for Your Generosity!</h3>
        <p>
            <br>
            <strong style="font-family: cursive">
                Dear Supporter,
            </strong>
            <br>
            <br>
            Thank you for your generous donation! Your contribution helps us continue our mission to deliver real news and
            amplify the voices that need to be heard. We couldn't do this without you.
            <br>
            <br>

            With gratitude,
            <br>
            <strong style="font-family: cursive">
                {{ env('APP_NAME') }}
            </strong>
        </p>
        
        
        <div class="mt-4">
            <a class="btn btn-custom-light py-3" href="{{route('donation.donate')}}"> <i class="fa fa-hand-holding-heart"></i> Donate again</a>
            <a class="btn btn-custom-light py-3" href="{{route('home')}}"> <i class="fa-solid fa-infinity"></i> Continue</a>
            
        </div>
        @include('partials.navigation.bottom')
    </main>
@endsection
