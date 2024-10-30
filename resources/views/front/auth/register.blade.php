@extends('front.main2')

@section('title', __('custom.signup'))

@section('content')

<div class="auth-container d-flex align-items-center justify-content-center">
    <div class="auth-header">
        <div class="bg-overlay"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>
    <div class="container form-container">
        <div class="row">
            <div class="logo d-flex justify-content-center mb-4">
                <a href="{{ route('front.index') }}"><img src="{{ asset('front') }}/imgs/logo-white.png" width="140"></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-lg-6 col-xl-5 mx-auto">
                <div class="card w-100">
                    <div class="card-body py-4">
                        <form id="register-form" action="{{ route('register') }}" method="post">
                            @csrf
                            <h4 class="text-center mb-4 fw-bold form-title">@lang('custom.signup')</h4>
                            <div class="d-flex gap-2">
                                <div class="input-group d-flex flex-column mb-3">
                                    <label for="first_name" class="fw-bold">@lang('custom.first-name')</label>
                                    <input id="first_name" name="first_name" value="{{ old('first_name') }}" class="form-control w-100" type="text" placeholder="@lang('custom.first-name')">
                                </div>
                                <div class="input-group d-flex flex-column mb-3">
                                    <label for="last_name" class="fw-bold">@lang('custom.last-name')</label>
                                    <input id="last_name" name="last_name" value="{{ old('last_name') }}" class="form-control w-100" type="text" placeholder="@lang('custom.enter-last-name')">
                                </div>
                            </div>
                            <div class="input-group d-flex flex-column mb-3">
                                <label for="email" class="fw-bold">@lang('custom.email')</label>
                                <input id="email" name="email" value="{{ old('email') }}" class="form-control w-100" type="email" placeholder="@lang('custom.enter-email')">
                            </div>
                            <div class="input-group d-flex flex-column mb-3">
                                <label for="phone" class="fw-bold">@lang('custom.phone')</label>
                                <div class="select-box">
                                    <div class="selected-option">
                                        <div class="country_data d-flex align-items-center me-2">
                                            <span id="default-country-icon"></span>&nbsp;
                                            <strong id="default-tel-code">+971</strong>
                                        </div>
                                        <input id="phone" name="phone" value="{{ old('phone') }}" class="form-control w-100" type="number" placeholder="@lang('custom.enter-phone')">
                                        <input type="hidden" name="country_code" id="country_code" value="971">
                                    </div>
                                    <div class="options">
                                        <ol id="countries_list"></ol>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group d-flex flex-column mb-3">
                                <label for="password" class="fw-bold">@lang('custom.password')</label>
                                <div class="input-holder position-relative d-flex justify-content-end">
                                    <i class="fa-solid fa-eye me-2"></i>
                                    <input id="password" name="password" class="form-control" type="password" placeholder="@lang('custom.password')">
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div class="input-group d-flex flex-column mb-3">
                                <label for="password_confirmation" class="fw-bold">@lang('custom.password-confirm')</label>
                                <div class="input-holder position-relative d-flex justify-content-end">
                                    <input id="password_confirmation" name="password_confirmation" class="form-control" type="password" placeholder="@lang('custom.enter-password-confirm')">
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary w-100" type="submit">@lang('custom.signup')</button>
                            </div>
                            <p class="mb-0 text-center mt-3">@lang('custom.signup.have-account') <a href="{{ route('login') }}" class="text-decoration-none fw-bold">@lang('custom.login')</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center gap-2 mt-1">
            <img src="{{ asset('front') }}/imgs/ar.svg" height="25" class="rounded-2" role="button">
            <!-- <span>Switch to AR.</span> -->
        </div>
    </div>
    <footer class="position-absolute bottom-0 w-100 text-center">
        <p class="mb-0 text-muted">
            @lang('custom.footer.copyright') &copy; 2024 {{ $website_settings->site_title }}.
        </p>
    </footer>
</div>

@endsection

@section('custom-js')
    <script src="{{ asset('front/libs/countries-data.js') }}"></script>
    <script src="{{ asset('front/libs/countries-flag.js') }}"></script>
    <script src="{{ asset('front/js/country-code.js') }}"></script>
@endsection