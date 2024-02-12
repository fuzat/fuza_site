<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
<meta name="author" content="">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="title" content="{{ (isset($seo) && !empty($seo)) ? $seo['title'] : $options['seo']['title'] }}">
<meta name="description" content="{{ (isset($seo) && !empty($seo)) ? $seo['description'] : $options['seo']['description'] }}">
<meta name="image" content="{{ (isset($seo) && !empty($seo)) ? $seo['image'] : $options['seo']['image'] }}">

<!-- facebook share-->
<meta property="og:title" content="{{ (isset($seo) && !empty($seo)) ? $seo['title'] : $options['seo']['title'] }}" />
<meta property="og:description" content="{{ (isset($seo) && !empty($seo)) ? $seo['description'] : $options['seo']['description'] }}" />
<meta property="og:image" content="{{ (isset($seo) && !empty($seo)) ? $seo['image'] : $options['seo']['image'] }}"/>
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="628" />
<!--end face -->

<script>
    (function (){
        var els = [	'section', 'article', 'hgroup', 'header', 'footer', 'nav', 'aside', 'figure', 'mark', 'time', 'ruby', 'rt', 'rp' ];
        for (var i=0; i<els.length; i++) {
            document.createElement(els[i]);
        }
    })();
</script>

<!--[if lt IE 9]>
<script src="{{ asset('js/html5shiv.js') }}" integrity="sha384-0s5Pv64cNZJieYFkXYOTId2HMA2Lfb6q2nAcx2n0RTLUnCAoTTsS0nKEO27XyKcY" crossorigin="anonymous"></script>
<script src="{{ asset('js/respond.min.js') }}" integrity="sha384-ZoaMbDF+4LeFxg6WdScQ9nnR1QC2MIRxA1O9KWEXQwns1G8UNyIEZIQidzb0T1fo" crossorigin="anonymous"></script>
<![endif]-->

<link href="{{ asset('css/style.css') }}" rel="stylesheet" />
<link rel="shortcut icon" href="{{ asset("images/favicon.ico") }}" />
@routes()
