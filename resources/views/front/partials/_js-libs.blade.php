<script>
    var rtl = {{ LaravelLocalization::getCurrentLocaleDirection() == "rtl" ? "true" : "false" }}
</script>
<script src="{{ asset('front') }}/libs/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ asset('front') }}/libs/jquery/jquery-3.6.4.min.js"></script>
<script src="{{ asset('front') }}/libs/owlcarousel/owl.carousel.min.js"></script>
<script src="{{ asset('front') }}/libs/sweetalert2/sweet.js"></script>
<script src="{{ asset('front') }}/js/minimized/main.min.js"></script>
@yield('custom-js')