@extends('layouts.app')

@section('content')
    <h5 class="text-light mb-2 mt-3">{{ __('titles.all_packages') }}</h5>
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <ul class="list-group">
                    <li>{{ $error }}</li>
                </ul>
            </div>
        @endforeach
    @endif
    <div class="row w-100 justify-content-center align-items-center">
        @if(\App\Models\Package::findActivePackage()->count() != 0)
            @foreach($packages as $package)
                <div class="col-4">
                    <div class="card rounded-10 border-0 shadow-lg cd-9 mx-auto mb-5 overflow-hidden text-light"
                         style="width: 18rem; background: #1f1c26;">

                        <div class="d-flex justify-content-center align-items-center">
                            <img class="card-img rounded-circle ms-2 me-2"
                                 src="{{ '/storage/' . $package->image }}"
                                 alt="Card image cap" style="width: 60px; height: 60px; border-radius: 100px">
                        </div>

                        <div class="card-head d-flex flex-md-row align-items-center p-2">
                            <div class="w-100 card-title mb-0 text-center">
                                <h5>{{ __('titles.name') .": ". $package->name }}</h5>
                                <small
                                    class="text-muted">{{ __('titles.description') .": ". $package->description }}</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center align-items-center">
                            <hr class="text-light w-75">
                        </div>

                        <div class="card-body py-2">

                            <div class="d-flex flex-column align-items-center mb-3 text-center">
                                <h6 class="w-100">{{ __('titles.coins') .": ". $package->coins }}</h6>
                                <h6 class="w-100">{{ __('titles.leftovers_package') .": ". $package->count }}</h6>
                            </div>

                            <div class="d-flex flex-column align-items-center mb-3 text-center">
                                <h6 class="w-100">{{ __('titles.validity') .": " }}
                                    <small>{{ \Carbon\Carbon::parse($package->deactivation)->diffForHumans() }}</small>
                                </h6>
                            </div>

                            <div class="d-flex flex-column align-items-center mb-3 text-center">
                                <h6 class="w-100">{{ __('titles.initial_price') .": "  }}
                                    <del class="text-danger">{{ $package->price . " " }}{{ __('titles.toman') }}</del>
                                </h6>
                                <h6 class="w-100">{{ __('titles.counted_price') .": ". $package->counted_price . " " }}{{ __('titles.toman') }}</h6>
                            </div>

                            @if(auth()->check())
                                <div class="w-100 d-flex justify-content-center mb-3">
                                    <form action="{{ route('order.packages') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $package->id }}">
                                        <button
                                            type="submit"
                                            class="btn btn-warning btn-sm">{{ __('titles.buy_package') }}</button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center">
                                    <small class="text-warning">
                                        {{ __('messages.login_for_join') }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-warning w-auto">
                {{ __('messages.no_package') }}
            </div>
        @endif
    </div>

@endsection
