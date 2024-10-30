@extends('front.main')

@section('title', __('custom.all-books'))

@section('content')

@include('front.partials._nav', ['rounded' => 0])

<div id="page-header" class="py-5">
    <div class="container d-flex">
        <div>
            <img src="{{ asset('front/imgs/group-of-books.png') }}" height="120">
        </div>
        <div class="d-flex flex-column align-items-start justify-content-evenly ps-md-5 ps-1">
            <span class="badge text-dark fw-bold">{{ $website_settings->site_title }}</span>
            <h2>@lang('custom.books.list-of-all')</h2>
        </div>
    </div>
</div>

<div id="books-page-body">
    <div class="container d-flex flex-wrap">
        <div class="col-md-3 col-12 py-md-5 pt-5">
            <div class="card border-0">
                <div class="card-body py-2">
                    <p class="fw-bold">@lang('custom.categories')</p>
                    <ul class="list-style-none ps-0 mb-0">
                        @foreach ($book_categories as $category)
                            <li class="mb-2">
                                <div class="input-group">
                                    <input name="category" id="cat{{ $category->id }}" type="checkbox" class="me-2" value="{{ $category->id }}" onclick="books_filters()" role="button" {{ request()->query('category_id') == $category->id ? 'checked' : '' }}>
                                    <label for="cat{{ $category->id }}" role="button">{{ $category->name }}</label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-12 d-flex flex-wrap py-md-5 pt-2">
            <div class="container-fluid px-md-1 px-0 mb-3">
                <div class="row px-md-3 px-3">
                    <div class="bg-white rounded-2 py-2">
                        <form action="{{ url()->current() }}" method="get" class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                            <div class="search-bar d-flex flex-fill">
                                <input type="text" class="form-control me-1" placeholder="Search..." name="search" onkeyup="books_filters()">
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <div class="sort d-flex align-items-center">
                                    <p class="mb-0 me-1 fw-bold">@lang('custom.sort')</p>
                                    <select class="form-select" name="sort" onchange="books_filters()">
                                        <option value="publish-new">@lang('custom.newest')</option>
                                        <option value="publish-old">@lang('custom.oldest')</option>
                                        <option value="name-a">@lang('custom.name') (@lang('custom.a-z'))</option>
                                        <option value="name-z">@lang('custom.name') (@lang('custom.z-a'))</option>
                                        <option value="rating-highest">@lang('custom.rating') (@lang('custom.highest'))</option>
                                        <option value="rating-lowest">@lang('custom.rating') (@lang('custom.lowest'))</option>
                                    </select>
                                </div>
                                <div class="limit d-flex align-items-center">
                                    <p class="mb-0 me-1 fw-bold">@lang('custom.show')</p>
                                    <select class="form-select" name="limit" onchange="books_filters()">
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
            <div class="books-container w-100">
                @include('front.parts.books-list')
            </div>
        </div>
    </div>
</div>

@endsection