@extends('front.main')

@section('title', __('custom.all-articles'))

@section('content')

@include('front.partials._nav', ['rounded' => 0])

<div id="page-header" class="py-5">
    <div class="container d-flex">
        <div>
            <img src="{{ asset('front/imgs/articles.png') }}" height="120" alt="@lang('custom.all-articles')" title="@lang('custom.all-articles')">
        </div>
        <div class="d-flex flex-column align-items-start justify-content-evenly ps-md-5 ps-2">
            <span class="badge text-dark fw-bold">{{ $website_settings->site_title }}</span>
            <h2>@lang('custom.articles.list-of-all')</h2>
        </div>
    </div>
</div>

<div id="articles-page-body">
    <div class="container d-flex flex-wrap">
        <div class="col-lg-2 col-md-4 col-12 py-md-5 pt-5">
            <div class="card border-0">
                <div class="card-body py-2">
                    <p class="fw-bold">@lang('custom.categories')</p>
                    <ul class="list-style-none ps-0 mb-0">
                        @foreach ($categories as $category)
                            <li class="mb-2">
                                <div class="input-group">
                                    <input name="category" id="cat{{ $category->id }}" type="checkbox" class="me-2" value="{{ $category->id }}" onclick="articles_filter()" role="button" {{ request()->query('category_id') == $category->id ? 'checked' : '' }}>
                                    <label for="cat{{ $category->id }}" role="button">{{ $category->name }}  ({{ $category->articles->count() }})</label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-10 col-md-8 col-12 d-flex flex-wrap py-md-5 pt-2">
            <div class="container-fluid px-md-1 px-0 mb-3">
                <div class="row px-3">
                    <div class="bg-white rounded-2 py-2">
                        <form action="{{ url()->current() }}" method="get" class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                            <div class="search-bar d-flex flex-fill">
                                <input type="text" class="form-control me-1" placeholder="Search..." name="search" onkeyup="articles_filter()">
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <div class="sort d-flex align-items-center">
                                    <p class="mb-0 me-1 fw-bold">@lang('custom.sort')</p>
                                    <select class="form-select" name="sort" onchange="articles_filter()">
                                        <option value="publish-new">@lang('custom.newest')</option>
                                        <option value="publish-old">@lang('custom.oldest')</option>
                                        <option value="title-a">@lang('custom.title') (@lang('custom.a-z'))</option>
                                        <option value="title-z">@lang('custom.title') (@lang('custom.z-a'))</option>
                                    </select>
                                </div>
                                <div class="limit d-flex align-items-center">
                                    <p class="mb-0 me-1 fw-bold">@lang('custom.show')</p>
                                    <select class="form-select" name="limit" onchange="articles_filter()">
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
            <div class="articles-container w-100">
                @include('front.parts.articles-list')
            </div>
        </div>
    </div>
</div>
@endsection