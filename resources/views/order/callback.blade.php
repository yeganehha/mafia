@extends('layouts.app')

@section('content')
    <div class="card text-white bg-dark mb-3 w-75">
        <div class="card-header text-center">
            <h4 class="text-warning m-2">{{ __('titles.pay_status') }}</h4>
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
                <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                <div class="d-flex flex-column justify-content-center align-items-center">
                    @if(request()->Status == 'OK')
                        <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_k6ciq2nn.json"
                                       background="transparent" speed="0.80" style="width: 250px; height: 250px;"
                                       autoplay></lottie-player>
                        <h3>{{ __('messages.payment_successful') }}</h3>
                        <h6>{{ __('titles.payment_code') }} : {{ $receipt }}</h6>
                        <a href="{{ route('profile.orders') }}"
                           class="btn btn-warning">{{ __('titles.orders_list') }}</a>
                    @else
                        <lottie-player src="https://assets6.lottiefiles.com/packages/lf20_ph09qu41.json"
                                       background="transparent" speed="0.8" style="width: 250px; height: 250px;"
                                       autoplay></lottie-player>
                        <h3>{{ __('messages.payment_unsuccessful') }}</h3>
                        <h6>{{ $receipt }}</h6>
                        <a href="{{ route('profile.orders') }}"
                           class="btn btn-warning">{{ __('titles.orders_list') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
