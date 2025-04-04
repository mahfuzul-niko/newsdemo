@extends('layouts.app')

@section('content')
    <main class="mobile-container">

        @include('partials.navigation.top')
        <main class="d-flex  align-items-center justify-content-center" style="height: 60vh">
            <form action="{{ route('admin.store.feedback') }}" method="POST"
                class="d-flex flex-column justify-content-around gap-5">
                @csrf
                <div class="text-center">
                    <h2 class="mb-4">how do you feel about our service?</h2>
                    <div class="row gap-2" style="justify-content: center;">
                        @for ($i = 1; $i <= 10; $i++)
                            <div class="col-2">
                                <div class="d-grid text-center ">
                                    <input type="radio" name="rating" value="{{ $i }}"
                                        class="btn-check w-100 " id="btn-check-{{ $i }}"
                                        @if ($i == 5) checked @endif autocomplete="off">
                                    <label class="btn-custom-light py-2 px-3"
                                        for="btn-check-{{ $i }}">{{ $i }}</label>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="form-floating m-3 fs-medium ">
                    <textarea type="text" class="form-control" name="message" id="floatingInput" value="" placeholder="" required
                        style="height: 150px"></textarea>
                    <label for="floatingInput">How was your experience</label>
                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary py-3 " style="border-radius: 20px">Submit</button>
                    </div>
                </div>
            </form>
        </main>
    </main>
    @include('partials.navigation.bottom')

@section('css')
@endsection
@endsection
