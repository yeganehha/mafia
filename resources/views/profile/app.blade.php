@extends('layouts.app')

@section('content')
    <div class="card text-white bg-dark mb-3 w-75">
        <div class="card-header">
            <ul class="list-group p-0 d-flex flex-row justify-content-start align-items-center">
                <li class="list-unstyled m-1 rounded-2"><a href="{{ route('profile.home') }}"
                                                           class="nav-link rounded-2 p-3 pt-2 pb-2 {{ \Route::currentRouteName() == "profile.home" ? "active":"" }}">{{ __('titles.profile') }}</a>
                </li>
                <li class="list-unstyled m-1 rounded-2"><a href="{{ route('profile.setting') }}"
                                                           class="nav-link rounded-2 p-3 pt-2 pb-2 {{ \Route::currentRouteName() == "profile.setting" ? "active":"" }}">{{ __('titles.setting') }}</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            @yield('card')
        </div>
    </div>
@endsection
