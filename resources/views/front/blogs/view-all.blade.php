@extends('front.main')

@section('title', __('custom.all-blogs'))

@section('content')

@include('front.partials._nav', ['rounded' => 0])

<div id="page-header" class="py-5">
    <div class="container d-flex">
        <div>
            <img src="{{ asset('front/imgs/blogs.png') }}" height="120">
        </div>
        <div class="d-flex flex-column align-items-start justify-content-evenly ps-5">
            <span class="badge text-dark fw-bold">{{ $website_settings->site_title }}</span>
            <h2>@lang('custom.blogs.list-of-all')</h2>
        </div>
    </div>
</div>

<div id="blogs-page-body">
    <div class="container d-flex">
        <div class="col-3 py-5">
            <div class="card border-0">
                <div class="card-body py-2">
                    <p class="fw-bold">@lang('custom.type')</p>
                    <ul class="list-style-none ps-0 mb-0">
                        <li class="mb-2">
                            <div class="input-group">
                                <input name="type" id="all-blogs" type="radio" class="me-2" value="all" onclick="blogs_filters()" role="button" {{ request()->query('type') == 'all' || !request()->query('type') ? 'checked' : '' }}>
                                <label for="all-blogs" role="button">@lang('custom.blogs.all')</label>
                            </div>
                        </li>
                        @if (Auth::check())
                            <li class="mb-2">
                                <div class="input-group">
                                    <input name="type" id="my-blogs" type="radio" class="me-2" value="my" onclick="blogs_filters()" role="button" {{ request()->query('type') == 'my' ? 'checked' : '' }}>
                                    <label for="my-blogs" role="button">@lang('custom.blogs.my')</label>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-9 d-flex flex-wrap py-5">
            <div class="container-fluid px-1 mb-1">
                @if (Auth::check())
                    <div class="row px-3 mb-3" data-bs-toggle="modal" data-bs-target="#addBlog">
                        <div class="open-create-post bg-white rounded-2 py-2 d-flex align-items-center gap-2">
                            <div class="image-holder d-flex justify-content-center align-items-center">
                                <img src="{{ Auth::user()->display_image }}" alt="">
                            </div>
                            <span class="rounded-3 w-100 h-100 px-2 d-flex align-items-center" role="button">@lang('custom.blogs.what-do-you-think')</span>
                        </div>
                    </div>
                @endif
                <div class="row px-3">
                    <div class="bg-white rounded-2 py-2">
                        <form action="{{ url()->current() }}" method="get" class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                            <div class="search-bar d-flex">
                                <input type="text" class="form-control me-1" placeholder="Search..." name="search" onkeyup="blogs_filters()">
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <div class="sort d-flex align-items-center">
                                    <p class="mb-0 me-1 fw-bold">@lang('custom.sort')</p>
                                    <select class="form-select" name="sort" onchange="blogs_filters()">
                                        <option value="publish-new">@lang('custom.newest')</option>
                                        <option value="publish-old">@lang('custom.oldest')</option>
                                        <option value="likes-highest">@lang('custom.likes') (@lang('custom.highest'))</option>
                                        <option value="likes-lowest">@lang('custom.likes') (@lang('custom.lowest'))</option>
                                    </select>
                                </div>
                                <div class="limit d-flex align-items-center">
                                    <p class="mb-0 me-1 fw-bold">@lang('custom.show')</p>
                                    <select class="form-select" name="limit" onchange="blogs_filters()">
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
            <div class="blogs-container w-100">
                @include('front.parts.blogs-list')
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addBlog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('custom.blogs.form-add-title')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add-blog-form" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                    @csrf
                    <textarea class="ckEditor" name="content" placeholder="Write your post..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">@lang('custom.blogs.add')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editBlog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('custom.blogs.form-edit-title')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-blog-form" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="blog_id">
                    <textarea class="ckEditor" name="content" placeholder="Write your post..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">@lang('custom.blogs.save')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    <script src="{{ asset('front/js/blogs.js') }}"></script>
@endsection