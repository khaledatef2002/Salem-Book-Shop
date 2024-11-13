<script>
    var rtl = {{ LaravelLocalization::getCurrentLocaleDirection() == "rtl" ? "true" : "false" }}
</script>
<script src="{{ asset('front') }}/libs/bootstrap/js/bootstrap.min.js" async></script>
<script src="{{ asset('front') }}/libs/jquery/jquery-3.6.4.min.js" defer></script>
<script src="{{ asset('front') }}/libs/owlcarousel/owl.carousel.min.js" defer></script>
<script src="{{ asset('front') }}/libs/sweetalert2/sweet.js" async></script>
<script src="{{ asset('front') }}/js/minimized/main.min.js" defer></script>
@yield('custom-js')