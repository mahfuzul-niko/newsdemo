@extends('layouts.app')

@section('content')
    <main class="mobile-container d-flex flex-column w-auto justify-content-center align-items-center vh-100 text-center">
        <i class="fa-solid fa-location-dot fa-4x"></i>
        <h1 class="mt-2">Enable Location Access for a Personalized Experience</h1>
        <p class="fs-small">
            To provide you with the most relevant content and services based on your current location, we need permission to
            access your device's location. Allowing location access will enable us to offer tailored recommendations. Your
            privacy is important to us, and your location data will only be used to enhance your experience. Please enable
            location access to continue.
        </p>
        <div class="d-flex flex-column gap-4">
            <button onclick="getLocation()" class="btn btn-custom-dark py-4">Allow</button>
            <a href="{{ url('/') }}" class="btn-none  fs-small text-center" id="submitBtn"> Skip </a>
        </div>
        <form action="{{ route('establish.store.location') }}" id="setLocation" method="post">
            @csrf
            <input type="hidden" id="country" name="country">
            <input type="hidden" id="state" name="state">
            <input type="hidden" id="city" name="city">
            <input type="hidden" id="zip" name="zip">
            <input type="hidden" id="address" name="address">
        </form>
    </main>
@endsection

@section('js')
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            console.log(position);
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            // Show loading screen
            document.getElementById('preloader').style.display = 'flex';

            const geocodeUrl =
                `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lon}&key={{ env('GOOGLE_MAP_API_KEY') }}`;

            fetch(geocodeUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "OK") {
                        const addressComponents = data.results[0].address_components;

                        let country = "";
                        let state = "";
                        let city = "";
                        let zip = "";
                        let address = data.results[0].formatted_address;

                        addressComponents.forEach(component => {
                            if (component.types.includes("country")) {
                                country = component.long_name;
                            }
                            if (component.types.includes("administrative_area_level_1")) {
                                state = component.long_name;
                            }
                            if (component.types.includes("locality")) {
                                city = component.long_name;
                            }

                            if (component.types.includes("postal_code")) {
                                zip = component.long_name;
                            }

                        });

                        document.getElementById('country').value = country;
                        document.getElementById('state').value = state;
                        document.getElementById('city').value = city;
                        document.getElementById('zip').value = zip;
                        document.getElementById('address').value = address;

                        document.getElementById('setLocation').submit();
                    } else {
                        alert("Geocode was not successful for the following reason: " + data.status);
                        // Hide loading screen
                        document.getElementById('loadingScreen').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error("Error fetching the geocode data: ", error);
                    // Hide loading screen
                    document.getElementById('loadingScreen').style.display = 'none';
                });
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
            // Hide loading screen
            document.getElementById('preloader').style.display = 'none';
        }
    </script>
@endsection
