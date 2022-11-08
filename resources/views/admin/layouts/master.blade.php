<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="/plugin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="/fonts/fontawesome/css/fontawesome.min.css">

    <link href="/css/admin.min.css" rel="stylesheet">
    @yield('css')

</head>

<body id="page-top">

<div id="wrapper">

    @include('admin.layouts.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"></nav>

            <div class="container-fluid text-right" dir="rtl">
                @yield('content')
            </div>
        </div>
    </div>

</div>

<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script src="/plugin/jquery/jquery.min.js"></script>
<script src="/plugin/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="/plugin/jquery-easing/jquery.easing.min.js"></script>

<script src="/js/admin.min.js"></script>
@yield('script')
</body>

</html>
