<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $website_settings->site_title }} - @yield('title')</title>
<link rel="shortcut icon" href="imgs/logo.png">
<link rel="stylesheet" href="{{ asset('front') }}/libs/bootstrap/css/bootstrap{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' ? '.rtl' : '' }}.min.css">
<link rel="stylesheet" href="{{ asset('front') }}/libs/fontawesome/css/all.min.css">
<link rel="stylesheet" href="{{ asset('front') }}/libs/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="{{ asset('front') }}/libs/owlcarousel/assets/owl.theme.default.min.css">
<link rel="stylesheet" href="{{ asset('front') }}/libs/sweetalert2/sweet.css">
<link rel="stylesheet" href="{{ asset('front') }}/css/main.css">
<link rel="stylesheet" href="{{ asset('front') }}/css/responsive.css">
@yield('custom-css')