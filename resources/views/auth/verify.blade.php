@extends('layouts.app')

@section('css')
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>
@endSection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-xl-9 mx-auto">
                <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden bg-dark bg-gradient">
                    <div class="card-img-left d-none d-md-flex">
                        <img src="/image/form-image.webp" alt="Login-image">
                    </div>
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 text-light fs-5"><b>{{ __('titles.confirm_code') }}</b></h5>
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    <ul class="list-group">
                                        <li>{{ $error }}</li>
                                    </ul>
                                </div>
                            @endforeach
                        @endif
                        <form method="POST" action="{{ route('auth.verify') }}">
                            @csrf
                            <input type="hidden" value="{{ session()->get('phone') }}" name="phone">
                            <div class="mb-3">
                                <label for="code" class="text-muted">{{ __('titles.submit_code') }}:</label>
                                <input id="code" type="number"
                                       class="border-secondary bg-dark text-light form-control @error('code') is-invalid @enderror mt-2"
                                       name="code" value="{{ old('code') }}" required autocomplete="code" autofocus>
                                @error('code')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-grid mb-2 mt-5">
                                <button class="btn btn-primary fw-bold text-uppercase" type="submit">
                                    {{ __('titles.check_code') }}
                                </button>
                                <a href="{{ route('home') }}"
                                   class="mt-3 btn btn-secondary fw-bold text-uppercase">{{ __('titles.home_page') }}</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
