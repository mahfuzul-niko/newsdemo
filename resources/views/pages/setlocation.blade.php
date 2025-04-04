@extends('layouts.app')

@section('content')
    <main class="mobile-container">
        @include('partials.navigation.top')
        <br>
        <br>
        <main id="news-container" class="px-3" style="margin-top: 20px;">
            
            <div class="d-flex gap-2" style="position: relative">
                <i class="fa fa-search" style="position:absolute;top:25%;left:20px"></i>
                <input type="text" id="location-search" class="form-control fs-small py-2 px-5"
                    placeholder="Search city or zip code">
            </div>

            <div id="location-results" class="mt-2">
                <!-- The location results will be populated here -->
            </div>

            <div>
                <div class="primary-locations">
                    <p class="fs-small text-primary mt-3">Primary Location</p>
                    <div>
                        <div class="location d-flex gap-3 align-items-center">
                            <i class="fa fa-home"></i>
                            <div>
                                <h4 class="fs-normal m-0">
                                    {{ auth()->user()->city }}
                                </h4>
                                <p class="text-secondary fs-small m-0">
                                    {{ auth()->user()->state }}, {{ auth()->user()->country }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="primary-locations">
                    <p class="fs-small text-primary mt-3">Locations you follow</p>
                    <div>
                        @if ($locations->count())
                            @foreach ($locations as $location)
                                <div class="location d-flex gap-3 align-items-center mt-3">
                                    <i class="fa fa-location-dot"></i>
                                    <div>
                                        <h4 class="fs-normal m-0">
                                            {{ $location->city }}
                                        </h4>
                                        <p class="text-secondary fs-small m-0">
                                            {{ $location->state }}, {{ $location->country }}
                                        </p>

                                        <a class="fs-tiny text-danger"
                                            href="{{ route('profile.location.remove', $location) }}">Remove</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="fs-tiny text-secondary text-center"> No location found</p>
                        @endif
                    </div>
                </div>
            </div>
        </main>

        @include('partials.navigation.bottom')
    </main>
@endsection

@section('js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&libraries=places"></script>
    <script>
        function initAutocomplete() {
            const input = document.getElementById('location-search');
            const autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.setFields(['address_components', 'geometry', 'name']);

            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                if (!place.geometry) {
                    console.error("No details available for input: '" + place.name + "'");
                    return;
                }


                let city = '';
                let state = '';
                let country = '';
                let address = place.name;
                let zip = '';

                for (const component of place.address_components) {
                    const componentType = component.types[0];

                    switch (componentType) {
                        case "locality":
                            city = component.long_name;
                            break;
                        case "administrative_area_level_1":
                            state = component.long_name; // Use .long_name for full state name
                            break;
                        case "country":
                            country = component.long_name;
                            break;
                        case "postal_code":
                            zip = component.long_name;
                            break;
                    }
                }

                const locationResults = document.getElementById('location-results');
                locationResults.innerHTML = `
                <p class="fs-small text-primary mt-3">Locations search</p>
                <div class="location d-flex gap-3 align-items-center">
                    <i class="fa fa-location-dot"></i>
                    <div>
                        <h4 class="fs-normal m-0">${city}</h4>
                        <p class="text-secondary fs-small m-0">
                            ${state}, ${zip}, ${country}
                        </p>
                        <div>
                            <form method="POST" action="/profile/set-location" style="display:inline;">
                                @csrf
                                <input type="hidden" name="city" value="${city}">
                                <input type="hidden" name="state" value="${state}">
                                <input type="hidden" name="zip" value="${zip}">
                                <input type="hidden" name="country" value="${country}">
                                <input type="hidden" name="address" value="${address}">
                                <button type="submit" name="action" value="primary" class="btn btn-link fs-tiny text-primary p-0">Set as primary</button>
                            </form>
                            |
                            <form method="POST" action="/profile/set-location" style="display:inline;">
                                @csrf
                                <input type="hidden" name="city" value="${city}">
                                <input type="hidden" name="state" value="${state}">
                                <input type="hidden" name="zip" value="${zip}">
                                <input type="hidden" name="country" value="${country}">
                                <input type="hidden" name="address" value="${address}">
                                <button type="submit" name="action" value="interest" class="btn btn-link fs-tiny text-primary p-0">Add as interest</button>
                            </form>
                        </div>
                    </div>
                </div>
            `;
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initAutocomplete();
        });
    </script>
@endsection
