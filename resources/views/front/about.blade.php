@extends('front.main')

@section('title', __('custom.about'))

@section('content')

@include('front.partials._nav', ['rounded' => '0'])

<section id="about-us-page" class="py-5">
    <div class="container text-center">
        <div class="border-0 p-4 rounded-4">
            <a href="https://suhail.ae"><img src="{{ asset('front/imgs/sohail-logo.png') }}" class="mb-4"></a>
            <h1 class="fw-bold fs-1 mb-4">@lang('custom.about.title')</h1>
            <p class="fs-5">@lang('custom.about.p1')</p>
            <p class="fs-5">@lang('custom.about.p2')</p>
            <p class="fs-5">@lang('custom.about.p3')</p>
            <p class="fs-5">@lang('custom.about.p4')</p>
            <p class="fs-5">@lang('custom.about.p5')</p>
            <p class="fs-5">@lang('custom.about.p6')</p>
            <p class="fs-5 mb-0">@lang('custom.about.p7')</p>
            <a href="https://suhail.ae" class="fw-bold btn btn-primary mt-3 px-3"><i class="fa-regular fa-share-from-square me-2"></i> suhail.ae</a>
        </div>
    </div>
</section>

@endsection