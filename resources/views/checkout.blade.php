@extends('layouts.app')
@section('content')
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .DemoPickerWrapper {
        padding: 0 12px;
        font-family: "Source Code Pro", monospace;
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
        border-radius: 3px;
        background: white;
        margin: 10px 0;
        width: 100%;
        }

        .DemoPicker {
        font-size: 18px;
        border-radius: 3px;
        background-color: white;
        height: 48px;
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        border: 0;
        width: 100%;
        color: #6772e5;
        outline: none;
        background: transparent;

        -webkit-appearance: none;
        }

        .DemoWrapper {
        margin: 0 auto;
        max-width: 500px;
        padding: 0 24px;
        display: flex;
        flex-direction: column;
        height: 100vh;
        }

        .Demo {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-bottom: 20px;
        }

        .Demo button {
        white-space: nowrap;
        border: 0;
        outline: 0;
        display: block !important;
        height: 40px;
        line-height: 40px;
        padding: 0 14px;
        box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
        color: #fff;
        border-radius: 4px;
        font-size: 15px;
        font-weight: 600;
        letter-spacing: 0.025em;
        background-color: #0ac2c8;
        text-decoration: none;
        -webkit-transition: all 150ms ease;
        transition: all 150ms ease;
        margin-top: 10px;
        }

        .Demo button:hover {
        color: #fff;
        cursor: pointer;
        background-color: #b6f8f8;
        transform: translateY(-1px);
        box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }

        .Demo input,
        .StripeElement {
        display: block;
        margin: 3px 0 20px 0;
        max-width: 500px;
        padding: 10px 14px;
        font-size: 1em;
        font-family: "Source Code Pro", monospace;
        box-shadow: rgba(50, 50, 93, 0.14902) 0px 1px 3px,
            rgba(0, 0, 0, 0.0196078) 0px 1px 0px;
        border: 0;
        outline: 0;
        border-radius: 4px;
        background: white;
        }

        .Demo input::placeholder {
        color: #aab7c4;
        }

        .Demo input:focus,
        .StripeElement--focus {
        box-shadow: rgba(50, 50, 93, 0.109804) 0px 4px 6px,
            rgba(0, 0, 0, 0.0784314) 0px 1px 3px;
        -webkit-transition: all 150ms ease;
        transition: all 150ms ease;
        }

        .StripeElement.IdealBankElement,
        .StripeElement.FpxBankElement,
        .StripeElement.PaymentRequestButton {
        padding: 0;
        }

        .StripeElement.PaymentRequestButton {
        height: 40px;
        }

    </style>
    <header class="bg-white">
        <div class="w-full md:max-w-7xl mx-auto py-1 px-3 sm:px-6 lg:px-8 bg-gray-800 h-10">
        <p class="italic text-lg md:text-xl text-white font-bold leading-8" style="font-family: 'Josefin Sans', sans-serif;">{{ __('CREATE DEPOSIT') }}</p>
        </div>
    </header>
    <div id="errorModal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
        <div class="w-11/12 bg-white absolute rounded-xl" style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
            <div class="float-right w-5 h-5">
                <a onclick="$('#errorModal').fadeOut(300);"><i class="fas fa-times"></i></a>
            </div>
          <div class="w-10/12 mx-auto mt-4">
            <p class="text-center text-md md:text-lg text-gray-700 mt-5 mb-5" id="message"></p>
          </div>
        </div>
    </div>

    <main class="md:max-w-7xl mx-auto">
        <div class="w-full">
            <div class="sm:px-0 bg-white pt-10 w-11/12 mx-auto">
                <div class="w-full md:max-w-xl bg-gray-100 rounded pb-8">
                    <div class="w-11/12 mx-auto Demo">
                        <div class="text-center text-2xl font-semibold pt-8">Submit Your Payment</div>
                        <hr class="mt-2" />
                        <form id="payment-form" autocomplete="off">
                            <label for="name" class="block w-full text-sm text-gray-700 mt-3">
                                Name on credit card
                                <input type="text" name="name" id="name" class="w-full border-none" style="padding: 7px 15px; box-shadow:rgb(50 50 93 / 15%) 0px 1px 3px, rgb(0 0 0 / 2%) 0px 1px 0px; border-radius:5px; font-size:14px;" />
                            </label>

                            <label for="card number" class="block w-full mt-6 text-sm text-gray-700">
                                Card number
                                <div id="card-number-element"></div>
                            </label>

                            <label for="card expiry" class="block w-full mt-6 text-sm text-gray-700">
                                Expiration date
                                <div id="card-expiry-element"></div>
                            </label>

                            <label for="card cvc" class="block w-full mt-6 text-sm text-gray-700">
                                CVC
                                <div id="card-cvc-element"></div>
                            </label>

                            <!-- We'll put the error messages in this element -->
                            <div id="card-errors" role="alert"></div>
                            <div class="w-full mt-6">
                                <button class="w-full" type="button" onclick="handleSubmit()">
                                    <span>
                                      <i class="fas fa-lock"></i> Deposit {{$price. ' ' . strtoupper($currency)}}
                                    </span>
                                    <img src="{{ asset('img/loading.gif') }}" alt="loading" class="mx-auto" style="width:30px; margin:5px; display:none;"/>
                                </button>
                              </div>
                              <div class="w-full mt-6">
                                <img src="{{ asset('img/stripe.png') }}" alt="powered by stripe" style='width:70%' class="float-right"/>
                              </div>
                              <div class="mt-5"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        var stripe = Stripe("pk_test_51HtrYKJyHziuhAX0GAQs9a6fajsFjcQanWHSmb384TC5aJLZdsPv4oCRAbUJ20kHozUSmkACPtk6abdlWzICm6k600VHofe1zg");
        var elements = stripe.elements();

        var style = {
            base: {
              color: "#424770",
              letterSpacing: "0.025em",
              fontFamily: "Source Code Pro, monospace",
              "::placeholder": {
                color: "#aab7c4"
              }
            },
            invalid: {
              color: "#9e2146"
            }
          }

        var cardNumberElement = elements.create('cardNumber', {style: style});
        cardNumberElement.mount("#card-number-element");

        var cardExpiryElement = elements.create('cardExpiry', {style: style});
        cardExpiryElement.mount("#card-expiry-element");

        var cardCvcElement = elements.create('cardCvc', {style: style});
        cardCvcElement.mount("#card-cvc-element")

        async function handleSubmit () {

            if(!stripe || !elements) {
                return;
            }
            $("button").css('pointer-events', 'none');
            var src = "{{asset('img/loading.gif')}}";
            $("button span").hide();
            $('button img').show();

            const payload = await stripe.createPaymentMethod({
                type: 'card',
                card: cardNumberElement,
                billing_details: {
                    name: $("input#name").val()
                }
            });

            const headers = {
              'Accept': 'application/json'
            }
            var api_token = $("meta[name=api-token]").attr('content');
            if(payload.error) {
                console.log(payload.error.message);
            } else {
                console.log(payload.paymentMethod.id);
                var url = "{{ url('/') }}/api/depositFunds?api_token=" + api_token;
                var data = {
                    "payment_id" : payload.paymentMethod.id,
                    "price" : "{{$price}}",
                    "currency" : "{{ $currency }}"
                };
                $.ajax({
                    url: url,
                    type: "POST",
                    headers,
                    data,
                    success: function(res) {
                        console.log(res);
                        window.location = "{{ url('/') }}/balance";
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        $("button").css('pointer-events', 'auto');
                        $("button span").show();
                        $("button img").hide();
                        $("#errorModal #message").text(XMLHttpRequest.responseJSON.message);
                        $("#errorModal").fadeIn(300).delay(2000);
                        console.log(XMLHttpRequest.responseJSON.message);
                    }
                });
            }
        }
    </script>
@endsection
