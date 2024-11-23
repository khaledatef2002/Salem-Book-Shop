@extends('front.main')

@section('title', __('custom.all-books'))

@section('content')

@include('front.partials._nav', ['rounded' => 0])

<div id="page-header" class="py-5">
    <div class="container d-flex">
        <div>
            <img src="{{ Auth::user()->display_image }}" height="120" alt="@lang('custom.group-of-books')" title="@lang('custom.group-of-books')" class="rounded-3">
        </div>
        <div class="d-flex flex-column align-items-start justify-content-evenly ps-md-5 ps-1">
            <span class="badge text-dark fw-bold">@lang('custom.profile')</span>
            <h2>{{ Auth::user()->full_name }}</h2>
        </div>
    </div>
</div>

<div id="books-page-body">
    <div class="container d-flex flex-wrap">
        <div class="col-md-9 col-12 d-flex flex-wrap py-md-5 pt-2">
            <div class="books-container w-100">
                @include('front.parts.profile-books-list')
            </div>
        </div>
    </div>
</div>

@endsection