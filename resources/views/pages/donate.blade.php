@extends('layouts.app')

@section('content')
    <main class="mobile-container">


        <main id="news-container" class="px-4" style="margin-top: 20px;">
            <br>
            <br>
            <p class="fs-small mx-auto">
                Donate to help us continue the chase for real news, and to build a platform for unheard voices
            </p>

            <h3>
                Select Amount
            </h3>

            <div class="row mx-auto mt-2 g-3 " style="width: 100%">
                @foreach ([10, 15, 20, 50] as $price)
                    <div class="col-6 ">
                        <div class="text-center ">
                            <input type="radio" name="price" @if ($loop->first) checked @endif
                                value="{{ $price }}" class="btn-check " id="btn-check-{{ $price }}"
                                autocomplete="off">
                            <label style="padding:40px" class="btn-custom-light h1"
                                for="btn-check-{{ $price }}">${{ $price }}</label>
                        </div>
                    </div>
                @endforeach
                <p class="text-center">
                    or
                </p>

                <div class="form-group">
                    <input type="text" class="form-control fs-small py-3" placeholder="Enter manually">
                </div>

            </div>

            <br>
            <br>
            <p>
                Enter Payment method
            </p>
            <form id="payment-form">
                <div id="card-element" class="form-control py-3" style="font-size: 1rem; border-radius: 10px;"></div>
                <br>
                <br>
                <div class="d-grid">
                    <button id="submit-button" class="btn-custom-dark py-3"><i class="fa fa-hand-holding-heart"></i>
                        Pay & Confirm</button>
                </div>
            </form>
            <div id="payment-message" class="hidden mt-3"></div>
        </main>

        @include('partials.navigation.bottom')
    </main>
@endsection
@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            }
        });
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');
        const paymentMessage = document.getElementById('payment-message');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            submitButton.disabled = true;
            paymentMessage.classList.add('hidden');

            const amount = document.querySelector('input[name="price"]:checked')?.value ||
                document.querySelector('input[placeholder="Enter manually"]').value;

            const {
                clientSecret
            } = await fetch('{{ route('donate.createPaymentIntent') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    amount: amount
                })
            }).then(response => response.json());

            const {
                error
            } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: cardElement
                }
            });

            if (error) {
                paymentMessage.textContent = error.message;
                paymentMessage.classList.remove('hidden');
            } else {
                window.location.href = "{{ route('donation.thankyou') }}";
                paymentMessage.textContent = 'Thank you for your donation!';
                paymentMessage.classList.remove('hidden');
            }

            submitButton.disabled = false;
        });
    </script>
@endsection
