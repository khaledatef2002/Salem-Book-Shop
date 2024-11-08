@extends('front.main')

@section('title', __('custom.about'))

@section('content')

@include('front.partials._nav', ['rounded' => '0'])

<div id="page-header" class="py-5 about-header">
    <div class="container d-flex flex-column align-items-center">
        <a href="https://suhail.ae"><img src="{{ asset('front/imgs/sohail-logo.png') }}" class="mb-4"></a>
        <h1 class="fw-bold fs-1 mb-4 text-center">@lang('custom.about.title')</h1>
    </div>
</div>

<section id="about-us-page-1" class="py-5 about-section">
    <div class="container d-flex justify-content-center flex-wrap align-items-center">
        <div class="col-md-3 image-container">
            <img src="{{ asset('storage/' . $website_settings->logo) }}" alt="">
        </div>
        <div class="col-md-9 border-0 p-4 rounded-4">
            <p class="fs-5">@lang('custom.about.p1')</p>
        </div>
    </div>
</section>

<section id="about-us-page-2" class="py-5 about-section">
    <div class="container d-flex justify-content-center flex-wrap-reverse align-items-center">
        <div class="col-md-9 border-0 p-4 rounded-4">
            <p class="fs-5">@lang('custom.about.p2')</p>
        </div>
        <div class="col-md-3 image-container">
            <img src="{{ asset('front/imgs/group-of-books.png') }}" alt="">
        </div>
    </div>
</section>

@endsection