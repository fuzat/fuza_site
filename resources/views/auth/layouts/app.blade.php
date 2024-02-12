<!DOCTYPE html>

<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
<!-- begin::Head -->
<head>
    <title>@yield('title')</title>
    @include('auth.layouts.head')
</head>
<!-- end::Head -->

<!-- begin::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    @yield('content')
</div>
<!-- end:: Page -->

@include('auth.layouts.script')
</body>
<!-- end::Body -->

</html>


