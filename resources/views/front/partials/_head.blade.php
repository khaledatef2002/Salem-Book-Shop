<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="{{ View::hasSection('description') ? View::getSection('description') : $website_settings->description }}">
<meta name="keywords" content="{{ View::hasSection('keywords') ? View::getSection('keywords') : $website_settings->keywords }}">
<meta name="author" content="{{ $website_settings->author }}">

<meta name="csrf-token" content="{{ csrf_token() }}">

<meta property="og:title" content="{{ View::hasSection('full-title') ? View::getSection('full-title') : $website_settings->site_title . " - " . View::getSection('title') }}">
<meta property="og:image" content="{{ View::hasSection('og-image') ? View::getSection('og-image') : asset('storage/' . $website_settings->banner) }}">
<meta property="og:type" content="{{ View::hasSection('type') ? View::getSection('type') : 'website' }}">

<meta name="twitter:card" content="{{ View::hasSection('og-image') ? View::getSection('og-image') : asset('storage/' . $website_settings->banner) }}">
<meta name="twitter:title" content="{{ View::hasSection('full-title') ? View::getSection('full-title') : $website_settings->site_title . " - " . View::getSection('title') }}">
<meta name="twitter:description" content="{{ View::hasSection('description') ? View::getSection('description') : $website_settings->description }}">
<meta name="twitter:image" content="{{ View::hasSection('og-image') ? View::getSection('og-image') : asset('storage/' . $website_settings->banner) }}">
@foreach(LaravelLocalization::getSupportedLocales() as $locale)
    <link rel="alternate" 
        href="{{ url($locale['locale'] . '/' . request()->path()) }}" 
        hreflang="{{ $locale['locale'] }}" />
@endforeach
<link rel="alternate" href="{{ url('/') }}" hreflang="x-default" />

<link rel="icon" href="{{ asset('storage/' . $website_settings->logo) }}" type="image/x-icon">

<title>{{ View::hasSection('full-title') ? View::getSection('full-title') : $website_settings->site_title . " - " . View::getSection('title') }}</title>
<link rel="shortcut icon" href="imgs/logo.png">
<link rel="stylesheet" href="{{ asset('front') }}/libs/bootstrap/css/bootstrap{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' ? '.rtl' : '' }}.min.css">
<link rel="stylesheet" href="{{ asset('front') }}/libs/fontawesome/css/all.min.css">
<link rel="stylesheet" href="{{ asset('front') }}/libs/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" href="{{ asset('front') }}/libs/owlcarousel/assets/owl.theme.default.min.css">
<link rel="stylesheet" href="{{ asset('front') }}/libs/sweetalert2/sweet.css">
<link rel="stylesheet" href="{{ asset('front') }}/css/main.css?id=3">
@if (LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
    <link rel="stylesheet" href="{{ asset('front') }}/css/main.rtl.css">
@endif
<link rel="stylesheet" href="{{ asset('front') }}/css/responsive.css">
@yield('custom-css')