<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('storage/'. $website_settings->logo) }}">

    <!-- jsvectormap css -->
    <link href="{{ asset('back') }}/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('back') }}/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{ asset('back') }}/js/layout.js"></script>
    
    {{-- RTL FILES --}}
    @if (LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
        <!-- Bootstrap Css -->
        <link href="{{ asset('back') }}/css/bootstrap-rtl.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('back') }}/css/app-rtl.min.css" id="app-style" rel="stylesheet" type="text/css" />
    @else
        <!-- Bootstrap Css -->
        <link href="{{ asset('back') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('back') }}/css/app.min.css" rel="stylesheet" type="text/css" />
    @endif

    {{-- Sweet Alert2 --}}
    <link href="{{ asset('back/libs/sweetalert2/sweetalert2.all.min.js') }}" rel="stylesheet" type="text-/css" />
    <!-- Icons Css -->
    <link href="{{ asset('back') }}/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('back') }}/css/custom.min.css" rel="stylesheet" type="text/css" />
</head>