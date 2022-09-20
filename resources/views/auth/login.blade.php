@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-xl-9 mx-auto">
                <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden bg-dark bg-gradient">
                    <div class="card-img-left d-none d-md-flex">
                        <img src="/image/form-image.webp" alt="Login-image">
                    </div>
                    <div class="card-body p-4 p-sm-5">
                        <h5 class="card-title text-center mb-5 text-light fs-5"><b>ورود / عضویت</b></h5>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="text-muted">نام:</label>
                                <input id="name" type="tel"
                                       class="border-secondary bg-dark text-light form-control @error('name') is-invalid @enderror mt-2"
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="text-muted">شماره موبایل:</label>
                                <input id="phone" type="tel"
                                       class="border-secondary bg-dark text-light form-control @error('phone') is-invalid @enderror mt-2"
                                       name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-grid mb-2 mt-5">
                                <button class="btn btn-primary fw-bold text-uppercase" type="submit">
                                    ارسال کد تایید
                                </button>
                                <a href="{{ route('home') }}"
                                   class="mt-3 btn btn-secondary fw-bold text-uppercase">صفحه اصلی</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
