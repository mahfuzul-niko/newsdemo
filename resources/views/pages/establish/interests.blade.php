@extends('layouts.app')

@section('content')
    <form action="{{ route('establish.store.interests') }}" method="post">
        @csrf
        <main
            class="mobile-container d-flex flex-column w-auto justify-content-center align-items-center text-center  vh-100">
            <p>{{ __('What news are you interested in?') }}</p>


            <div class="row w-auto g-2">
                @foreach ($categories->chunk(2) as $cols)
                    @foreach ($cols as $category)
                        <div class="col-6">
                            <div class="d-grid text-center">
                                <input type="checkbox" name="interests[]" value="{{ $category->id }}" class="btn-check"
                                    id="btn-check-{{ $category->id }}" @if ($first && in_array($category->id, App\Helpers\System::getInterests())) checked @endif
                                    autocomplete="off">
                                <label class="py-3 btn-custom-light "
                                    for="btn-check-{{ $category->id }}">{{ __($category->name) }}</label>
                            </div>
                        </div>
                    @endforeach
                @endforeach

            </div>

            <div class="d-flex gap-2">

                @if ($first == true)
                    <a href="{{ url('/') }}" class="btn-none mt-5 fs-small text-center" id=""> {{__('Home')}} </a>
                @endif
                <input type="submit" class="btn-none mt-5 fs-small text-center" id="submitBtn" value="Not now">
            </div>
        </main>
    </form>

@section('js')
    <script>
        const interestPicked = () => {
            let btn = document.getElementById('submitBtn');
            console.log(document.querySelectorAll('.btn-check:checked').length);
            if (document.querySelectorAll('.btn-check:checked').length > 0) {
                btn.value = "{{__('Next')}}";
            } else {
                btn.value = "{{ __('Not now') }}";
            }
        };



        // Use forEach to add the event listener correctly
        interestPicked();
        [...document.getElementsByClassName('btn-check')].forEach(el => {
            el.addEventListener('click', interestPicked);
        });
    </script>
@endsection
@endsection
