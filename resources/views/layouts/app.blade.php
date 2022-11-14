<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('titles.app_name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Links -->
    <link rel="stylesheet" href="/plugin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="/fonts/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="/plugin/toastr/css/toastr.min.css">
    <link rel="stylesheet" href="/css/app.css">
    @yield('css')
    <style>
        .dropdown-item:hover {
            background: #101113;
        }
    </style>
</head>
<body dir="rtl" class="bg-dark">
<div id="app">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand text-info" href="{{ url('/') }}">
                {{ __('titles.app_name') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('auth.showLogin'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('auth.showLogin') }}">{{ __('titles.login') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end bg-dark text-center" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item text-light mb-1" href="{{ route('home') }}">
                                    {{ __('titles.home_page') }}
                                </a>
                                <a class="dropdown-item text-light mb-1" href="{{ route('profile.home') }}">
                                    {{ __('titles.dashboard') }}
                                </a>
                                <a class="dropdown-item text-light mb-1" href="{{ route('order.coin') }}">
                                    {{ __('titles.buy_coin') }}
                                </a>
                                <a class="dropdown-item text-light mb-1" href="{{ route('order.packages') }}">
                                    {{ __('titles.packages') }}
                                </a>

                                <hr class="text-light mb-2 mt-2">


                                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-light mb-1">
                                        {{ __('titles.exit') }}
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4 d-flex flex-column justify-content-center align-items-center">
        @yield('content')
    </main>
</div>
<!-- Scripts -->
<script src="/plugin/jquery/jquery.min.js"></script>
<script src="/plugin/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/plugin/toastr/js/toastr.min.js"></script>
<script src="/js/app.js" defer></script>
@yield('script')
</body>
</html>
