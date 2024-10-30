@extends('front.main')

@section('title', $article->title)

@section('content')

@include('front.partials._nav', ['rounded' => 0])

<div id="article-info" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="col-lg-9 col-12 article-image-holder d-flex justify-content-center align-items-center rounded-3">
                    <img src="{{ asset('front/' . $article->cover) }}" class="rounded-3">
                </div>
                <div class="col-12 d-flex flex-wrap gap-4 mt-3">
                    <div class="col-lg-9 col-12 card border-0 rounded-3 p-3">
                        <h1 class="text-center">{{ $article->title }}</h1>
                        <div class="content">
                            {{ $article->content }}
                        </div>
                        <div class="article-meta d-flex flex-wrap justify-content-between mt-3 gap-2">
                            <div class="d-flex gap-3">
                                <div class="likes-count d-flex flex-fill flex-column align-items-center justify-content-end">
                                    @csrf
                                    <button class="d-flex align-items-center gap-2 btn btn-sm btn-{{auth()->check() && $article->authLikes->isNotEmpty() ? '' : 'outline-'}}primary {{ auth()->check() ? 'like-article' : 'auth-to-like' }}" 
                                        data-article-id="{{ $article->id }}">
                                            <i class="fa-solid fa-thumbs-up"></i>
                                            <p class="mb-0"> <span class="text">@lang(auth()->check() && $article->authLikes->isNotEmpty() ? 'custom.liked' : 'custom.like')</span> (<span class="count">{{ $article->likes->count() }}</span>)</p>
                                    </button>
                                </div>
                                <div>
                                    <button class="d-flex align-items-center gap-2 btn btn-sm btn-outline-primary {{ auth()->check() ? 'open-article-comment' : 'auth-to-comment' }}" >
                                            <i class="fa-solid fa-comments"></i>
                                            <p class="mb-0"> @lang('custom.articles.comments') (<span>{{ $article->comments->count() }}</span>)</p>
                                    </button>
                                </div>
                            </div>
                            <div class="d-flex gap-3">
                                <span class="article-category">
                                    <i class="fa-solid fa-certificate"></i>
                                    {{ $article->category->name }}
                                </span>
                                <span class="article-publish-date">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    {{ $article->created_at->format('d M, Y') }} 
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex-fill">
                        <div class="card border-0 px-3 pt-3 pb-1">
                            <p class="fw-bold">@lang('custom.categories')</p>
                            <ul class="list-style-none ps-0 mb-0">
                                @foreach ($categories as $category)
                                    <li class="mb-2">
                                        <a href="{{ route('front.article.index', ['category_id' => $category->id]) }}" class="text-decoration-none">{{ $category->name }} ({{ $category->articles->count() }})</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-3 mt-4">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active border-0" aria-current="page" data-bs-toggle="list" href="#comments">@lang('custom.articles.comments')</a>
                </li>
            </ul>
            <div class="card border-0">
                <div class="card-body">
                    <div class="tab-content p-md-3">
                        <div class="tab-pane fade show active" id="comments" role="tabpanel">
                            @if (Auth::check())
                                <form id="add-comment-form" class="comment-form">
                                    @csrf
                                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                                    <p class="fw-bold fs-4 mb-0">@lang('custom.article.add-comment')</p>
                                    <div class="d-flex flex-md-row flex-column gap-2">
                                        <div class="auth-image-holder d-flex align-items-center justify-content-center">
                                            <img src="{{ asset(auth()->user()->display_image) }}">
                                        </div>
                                        <textarea name="comment" class="form-control" placeholder="Leave comment..." rows="4"></textarea>
                                    </div>
                                    <button class="btn btn-primary mt-2 px-3 d-block ms-auto" type="submit">@lang('custom.send')</button>
                                </form>
                            @else
                                <p class="fw-bold fs-4 mb-0">@lang('custom.article.add-comment')</p>
                                <a href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i> @lang('custom.article.comment.sign-in-to-comment')</a>
                            @endif
                            @if ($article->comments->count() > 0)
                                <div class="comment-list">
                                    <ul class="list-style-none ps-0 mb-0">
                                        @include('front.parts.single-article-comments')
                                    </ul>
                                </div>
                                {{ $comments->links('pagination::bootstrap-4') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
    <script src="{{ asset('front/js/single-article.js') }}"></script>
@endsection