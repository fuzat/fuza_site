<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">

<head>
    <title>@yield('title') | {{ env('APP_NAME') }}</title>

    @include('front.layout.head')
    @yield('css')
</head>
<body>
<div class="index">
    @include('front.layout.header')
    <div class="index_middle">
        @yield('content')
    </div>

    @include('front.layout.footer')
</div>
<div class="scroll-top-wrapper ">
    <img src="{{ asset('images/top.png') }}" width="40" height="40" alt=""/>
</div>

@include('front.layout.script')
@yield('script')
</body>
</html>
