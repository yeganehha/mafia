@extends('layouts.app')

@section('css')
    <style>
        .payment-methods .method {
            width: 45%;
            position: relative;
            transition: all 0.2s linear;
        }

        .payment-methods .method.active {
            box-shadow: rgba(0, 0, 0, 0.15) 0px 15px 25px, rgba(0, 0, 0, 0.05) 0px 5px 10px;
        }

        .payment-methods .method:hover {
            box-shadow: rgba(0, 0, 0, 0.15) 0px 15px 25px, rgba(0, 0, 0, 0.05) 0px 5px 10px;
        }

        .payment-methods .method input {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 0;
            opacity: 0;
            cursor: pointer;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endsection
@section('content')
    <div class="card text-white bg-dark mb-3 w-75">
        <div class="card-header text-center">
            <h4 class="text-warning m-2">{{ __('titles.buy_coin') }}</h4>
        </div>

        <div class="card-body">
            <div class="row mx-auto">
                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            <ul class="list-group">
                                <li>{{ $error }}</li>
                            </ul>
                        </div>
                    @endforeach
                @endif
                <form action="{{ route('order.coin') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="mb-3">
                                <label for="value" class="form-label text-muted">{{ __('titles.number_of_coins') }}
                                    :</label>
                                <input id="value" type="number"
                                       class="border-secondary bg-dark text-light form-control @error('value') is-invalid @enderror mt-2"
                                       name="value" placeholder="{{ __('messages.number_of_coins') }}" required
                                       autocomplete="value"
                                       autofocus>
                                @error('value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 mb-3">

                            <div class="payment-methods row d-flex justify-content-around align-items-center">
                                <p class="text-center">{{ __('titles.payment_gateway') }}</p>
                                <div
                                    class="col-6 method mt-3 d-flex justify-content-center align-items-center p-3 rounded-3 active">
                                    <label for="zarinpal"><img src="/image/zarinpal.svg" style="width: 150px;"
                                                               alt="zarinpal"></label>
                                    <input name="gateway" id="zarinpal" type="radio" value="zarinpal"
                                           class="form-check-input" checked>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <p>{{ __('titles.total_amount') }} <b id="total-amount"
                                                              class="text-danger">0</b> {{ __('titles.toman') }}</p>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('titles.pay') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#value').on('input', function () {
                $('#total-amount').text($(this).val() * 1000)
            });

            $('.method').click(function () {
                $('.method').removeClass("active");
                $(this).addClass("active");
            });
        });
    </script>
@endsection
