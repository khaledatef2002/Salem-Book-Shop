<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">
<head>
    @include('front.partials._head')
</head>
<body dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

    @yield('content')

    @include('front.partials._footer')
    
    @include('front.partials._js-libs')
</body>
</html>