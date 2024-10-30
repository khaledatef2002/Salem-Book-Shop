@extends('front.main')

@section('title', __('custom.quotes'))

@section('content')

@include('front.partials._nav', ['rounded' => 0])

<div id="page-header" class="py-5">
    <div class="container d-flex">
        <div class="d-flex align-items-center">
            <i class="fa-solid fa-quote-left fs-1"></i> 
        </div>
        <div class="d-flex flex-column align-items-start justify-content-evenly ps-5">
            <span class="badge text-dark fw-bold mb-2">{{ $website_settings->site_title }}</span>
            <h2>@lang('custom.quotes.list-of-all')</h2>
        </div>
    </div>
</div>

<div id="quotes-page-body">
    <div class="container d-flex">
        <div class="col-lg-9 col-12 d-flex flex-wrap py-5 mx-auto">
            <div class="container-fluid px-1 mb-3">
                <div class="row px-3">
                    <div class="bg-white rounded-2 py-2">
                        <form action="{{ url()->current() }}" method="get" class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                            <div class="search-bar d-flex flex-fill">
                                <input type="text" class="form-control me-1" placeholder="@lang('custom.search') @lang('custom.author')" name="search" onkeyup="quotes_filters()">
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <div class="sort d-flex align-items-center">
                                    <p class="mb-0 me-1 fw-bold">@lang('custom.sort')</p>
                                    <select class="form-select" name="sort" onchange="quotes_filters()">
                                        <option value="publish-new">@lang('custom.newest')</option>
                                        <option value="publish-old">@lang('custom.oldest')</option>
                                        <option value="name-a">@lang('custom.author-name') (@lang('custom.a-z'))</option>
                                        <option value="name-z">@lang('custom.author-name') (@lang('custom.z-a'))</option>
                                        <option value="likes-highest">@lang('custom.likes') (@lang('custom.highest'))</option>
                                        <option value="likes-lowest">@lang('custom.likes') (@lang('custom.lowest'))</option>
                                    </select>
                                </div>
                                <div class="limit d-flex align-items-center">
                                    <p class="mb-0 me-1 fw-bold">@lang('custom.show')</p>
                                    <select class="form-select" name="limit" onchange="quotes_filters()">
                                        <option value="13" {{ request()->limit == 13 ? 'selected' : '' }}>13</option>
                                        <option value="25" {{ request()->limit == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request()->limit == 50 ? 'selected' : '' }}>50</option>
                                        <option value="70" {{ request()->limit == 70 ? 'selected' : '' }}>70</option>
                                        <option value="100" {{ request()->limit == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="quotes-container w-100">
                @include('front.parts.quotes-list')
            </div>
        </div>
    </div>
</div>

@endsection