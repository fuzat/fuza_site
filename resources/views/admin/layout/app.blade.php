<html lang="{{ \LaravelLocalization::getCurrentLocale() }}" >

<!-- begin::Head -->
<head>
    @include("admin.layout.head")
    @yield('css')
</head>
<!-- end::Head -->

<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <!-- BEGIN: Header -->
    @include("admin.layout.header")
    <!-- END: Header -->

    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <!-- BEGIN: Left Aside -->
        @include("admin.layout.left_sidebar")
        <!-- END: Left Aside -->
        @yield('content')
    </div>
    <!-- end:: Body -->

    <!-- begin::Footer -->
    @include("admin.layout.footer")
    <!-- end::Footer -->
</div>
<!-- end:: Page -->

<!-- begin::Scroll Top -->
<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
    <i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->

<!--begin::Base Scripts -->
@include("admin.layout.base_script")
<!--end::Base Scripts -->

<!--begin::Page Scripts -->
@yield('script')
<!--end::Base Scripts -->

</body>
</html>
