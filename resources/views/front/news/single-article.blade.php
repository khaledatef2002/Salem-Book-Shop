@extends('front.main')

@section('title', $article->title)

@section('content')

@include('front.partials._nav', ['rounded' => 0])

<div id="article-info" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="col-9 article-image-holder d-flex justify-content-center align-items-center">
                    <img src="{{ asset('front/' . $article->cover) }}">
                </div>
                <div class="col-12 d-flex gap-4 mt-3">
                    <div class="col-9 card border-0 rounded-3 p-3">
                        <h1 class="text-center">{{ $article->title }}</h1>
                        <div class="content">
                            {{ $article->content }}
                        </div>
                        <div class="article-meta d-flex justify-content-between mt-3">
                            <div class="d-flex gap-3">
                                <div class="likes-count d-flex flex-fill flex-column align-items-center justify-content-end ms-2">
                                    @if (Auth::check())
                                        @csrf
                                        <button class="btn btn-sm btn-{{$article->authLikes->isNotEmpty() ? '' : 'outline-'}}primary like-article" 
                                            data-article-id="{{ $article->id }}">
                                                <i class="fa-solid fa-thumbs-up"></i>
                                                <p class="mb-0"> @lang($article->authLikes->isNotEmpty() ? 'custom.liked' : 'custom.like') (<span>{{ $article->likes->count() }}</span>)</p>
                                        </button>
                                    @else
                                        <small class="fs-6"></small>
                                        @csrf
                                        <button class="btn btn-sm btn-outline-primary auth-to-like d-flex gap-2 align-items-center">
                                                <i class="fa-solid fa-thumbs-up"></i>
                                                <p class="mb-0"> @lang('custom.like') (<span class="count">{{ $article->likes->count() }}</span>)</p>
                                        </button>
                                    @endif
                                </div>
                                <span class="article-comments">
                                    <i class="fa-regular fa-comments"></i>
                                    {{ $article->comments->count() }}
                                </span>
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
    </div>
</div>
@endsection