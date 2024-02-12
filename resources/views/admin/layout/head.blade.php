<meta charset="utf-8" />

<title>
    @yield('title') | {{ env('APP_NAME') }}
</title>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="description" content="Latest updates and statistic charts">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<script src="{{ asset('app/js/axios.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/app/js/webfont.js') }}" type="text/javascript"></script>
<script>
    WebFont.load({
        google: {"families":["Montserrat:300,400,500,600,700","Roboto:300,400,500,600,700"]},
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>

<link href="{{ asset("assets/vendors/base/vendors.bundle.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ asset("assets/demo/demo3/base/style.bundle.css") }}" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.6/css/flag-icon.min.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="{{ asset("images/favicon.ico") }}" />

<style type="text/css">
    .m-menu__link {
        display: table !important;
    }

    @media (max-width: 993px) {
        .m-menu__link {
            display: block !important;
        }
    }
</style>
@routes()
