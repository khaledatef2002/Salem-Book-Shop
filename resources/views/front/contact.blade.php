@extends('front.main')

@section('title', __('custom.contct-us'))

@section('content')

@include('front.partials._nav', ['rounded' => '0'])

<div id="page-header" class="py-5">
    <div class="container d-flex">
        <div>
            <img src="{{ asset('front/imgs/contact.png') }}" height="120" alt="@lang('custom.telephone')" title="@lang('custom.contact-us')">
        </div>
        <div class="d-flex flex-column align-items-start justify-content-evenly ps-5">
            <span class="badge text-dark fw-bold">{{ $website_settings->site_title }}</span>
            <h2>@lang('custom.contact-us')</h2>
        </div>
    </div>
</div>

<section id="contact-page" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-12 mx-auto">
                <form id="contact-form" class="d-flex flex-column align-items-center card border-0 p-3">
                    @csrf
                    <div class="user-info mx-auto d-block">
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset(Auth::user()->display_image) }}" width="70px" class="rounded-5" alt="{{ Auth::user()->full_name }} @lang('dashboard.person.image')" title="@lang('custom.you')">
                        </div>
                        <p class="fw-bold">{{ Auth::user()->full_name }}</p>
                    </div>
                    <div class="input-group d-flex flex-column">
                        <label for="message" class="fw-bold">@lang('custom.message') </label>
                        <textarea id="message" name="message" class="form-control w-100 rounded-3" rows="7" placeholder="@lang('custom.enter-message')"></textarea>
                    </div>
                    <div class="submit-button d-flex justify-content-end mt-2 w-100">
                        <button class="btn btn-primary" type="submit">@lang('custom.submit')</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-3 col-md-10 col-12 mx-auto">
            <div class="col-md-6 col-12 p-1">
                <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d4458.146987456637!2d55.937766884978544!3d25.77999318362851!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjXCsDQ2JzQ4LjAiTiA1NcKwNTYnMDguMSJF!5e1!3m2!1sar!2seg!4v1729442170942!5m2!1sar!2seg" 
                width="100%"
                height="100%"
                style="min-height: 250px"
                style="border:0;" allowfullscreen="" 
                loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                class="rounded-3"></iframe>
            </div>
            <div class="col-md-6 col-12 card p-2 d-flex flex-column justify-content-between">
                <ul class="m-0 px-3 border-0 h-100 list-style-none d-flex flex-column justify-content-center">
                    <h3 class="mb-3">@lang('custom.general-contact')</h3>
                    <li class="py-2 mx-3 ps-1">
                        <i class="fa-solid fa-at"></i>
                        <a href="mailto:salembookshop@suhail.ae" class="fw-bold text-decoration-none">salembookshop@suhail.ae</a>
                    </li>
                    <li class="py-2 mx-3 ps-1">
                        <i class="fa-solid fa-location-dot"></i>
                        <a href="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d4458.146987456637!2d55.937766884978544!3d25.77999318362851!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjXCsDQ2JzQ4LjAiTiA1NcKwNTYnMDguMSJF!5e1!3m2!1sar!2seg!4v1729442170942!5m2!1sar!2seg" class="fw-bold text-decoration-none">@lang('custom.location')</a>
                    </li>
                    <li class="py-2 mx-3 ps-1">
                        <i class="fa-solid fa-phone"></i>
                        <a href="tel:971569755226" class="fw-bold text-decoration-none">+971569755226</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

@endsection