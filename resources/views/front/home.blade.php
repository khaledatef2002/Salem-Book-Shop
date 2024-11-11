@extends('front.main')

@section('title', __('custom.home'))

@section('content')

@include('front.partials._nav-container')

@include('front.partials._header')

@if ($comming_events?->count() > 0)
    <section id="comming-event" class="py-5">
        <div class="container-lg container-md px-lg-0">
            <div class="event rounded-5">
                <div class="backgound-overlay d-flex flex-column justify-content-evenly align-items-center h-100">
                    <h2 class="text-center fw-bold fs-1">@lang('custom.home.events.comming')</h2>
                    <div>
                        <h3 class="text-center fs-1 mb-4">{{ $comming_events->title }}</h3>
                        <div class="time-frame d-flex flex-md-row flex-column justify-content-center align-items-center gap-2">
                            <p class="frame day-frame border rounded-4 py-2 px-4 fs-4 mb-0">
                                <span class="number">{{ $comming_events->remaining['days'] }}</span>
                                <span class="text">@lang('custom.days')</span>
                            </p>
                            <span class="colon fs-4 d-md-block d-none">:</span>
                            <p class="frame hours-frame border rounded-4 py-2 px-4 fs-4 mb-0">
                                <span class="number">{{ $comming_events->remaining['hours'] }}</span>
                                <span class="text">@lang('custom.hours')</span>
                            </p>
                            <span class="colon fs-4 d-md-block d-none">:</span>
                            <p class="frame min-frame border rounded-4 py-2 px-4 fs-4 mb-0">
                                <span class="number">{{ $comming_events->remaining['min'] }}</span>
                                <span class="text">@lang('custom.minutes')</span>
                            </p>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-2 align-items-center justify-contetn-center">
                        @if (Auth::check())
                            <form id="unattend-form" style="display: {{ $comming_events->authAttendants->count() ? 'block' : 'none' }}" onsubmit="main_unattend_event(event, this, {{ $comming_events->id }})">
                                @csrf
                                <button class="btn btn-danger border-0 rounded-4 text-white py-2 px-5 fs-5" type="submit">@lang('custom.events.unattend')</button>
                            </form>    
                            <form id="attend-form" style="display: {{ $comming_events->authAttendants->count() ? 'none' : 'block' }}" onsubmit="main_attend_event(event, this, {{ $comming_events->id }})">
                                @csrf
                                <button class="btn btn-primary border-0 rounded-4 text-white py-2 px-5 fs-5" type="submit">@lang('custom.events.attend')</button>
                            </form> 
                        @endif
                        <a href="{{ route('front.event.show', $comming_events) }}" class="read-more btn text-dark rounded-4 py-2 px-5 fs-5">@lang('custom.readmore')</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

@if ($books->count() > 0)
    <section id="special-picks-for-you" class="py-5 section-back">
        <div class="container-lg container-md px-lg-0">
            <div class="row">
                <h2 class="text-center text-dark mb-4 fw-bold fs-1">@lang('custom.home.books.title')</h2>
            </div>
            <div class="row">
                <div class="owl-carousel activity-carousel pe-0">
                    @foreach ($books as $book)
                    <a href="{{ route('front.book.show', $book) }}" class="text-decoration-none text-dark">
                        <div class="items h-100">
                            <div class="item-container h-100 px-1 py-4 rounded-4 d-flex flex-column justify-content-between">
                                <div class="d-flex justify-content-center align-items-center">
                                    <img src="{{ asset('storage/' . $book->images->first()->url) }}" class="mx-2" alt="{{ $book->title }}" title="{{ $book->title }}">
                                </div>
                                <div class="content d-flex flex-column justify-content-evenly align-items-center mt-3">
                                    <h3 class="mb-3 fs-4 text-center fw-bold">{{ $book->title }}</h3>
                                    <h3 class="text-dark fs-6 mb-0">
                                        <i class="fa-solid fa-feather"></i>
                                        <span>{{ $book->author->name }}</span>
                                    </h3>
                                    <p class="fw-bold fs-6 mb-0" style="color: rgb(224 168 0) !important">
                                        <i class="fa-regular fa-star"></i>
                                        <span>({{ $book->avg_review }})</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <a class="view-all-link btn btn-primary text-decoration-none px-5 py-2" href="{{ route('front.book.index') }}" style="width: fit-content">
                    <span>@lang('custom.viewall') </span>
                </a>
            </div>
        </div>
    </section>
@endif

@if ($quotes->count() > 0)
    <section id="quotes">
        <div class="container-fluid px-0">
            <div class="quote-back d-flex align-items-center">
                <div class="container-lg container-md text-center d-flex align-items-center justify-content-center">
                    <div class="owl-carousel quotes-carousel pe-0">
                        @foreach ($quotes as $quote)
                            <div class="items">
                                <div class="item-container px-4 py-4 rounded-4 d-flex flex-column text-white h-100">
                                    <i class="fa-solid fa-quote-right fs-1"></i>
                                    <p class="my-3">{{ $quote->title }}</p>
                                    <div class="author-image-container mx-auto mb-3 mt-3">
                                        <img src="{{ asset('') }}/{{ $quote->author->image }}" alt="{{ $quote->author->name }}" title="{{ $quote->author->name }}">
                                    </div>
                                    <p>{{ $quote->author->name }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<section id="video-and-top-authors" class="py-5 section-back">
    <div class="container-lg container-md d-flex flex-wrap flex-lg-row flex-md-column align-items-center">
        <div class="col-lg-6 col-12 d-flex flex-fill align-items-center justify-content-center px-2 mb-lg-0 mb-4">
            <iframe 
                class="rounded-3"
                src="https://www.youtube.com/embed/iT03JIH2Drg" 
                title="مكتبة سالم - قلب المعرفة في رأس الخيمة | ندوات مجانية، صناعة كتب، وكنوز معرفية" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen
                loading="lazy"></iframe>
        </div>
        @if($top_authors->count() > 0)
            <div class="top-authors col-lg-6 d-flex flex-column px-2 gap-2">
                <div class="top-authors-header py-2 rounded-3">
                    <h2 class="text-center mb-0">@lang('custom.home.top-authors')</h2>
                </div>
                <div class="top-authors-body d-flex flex-column gap-3">
                    @foreach ($top_authors as $author)
                        <div class="author d-flex rounded-4 gap-2 justify-content-start p-2">
                            <div class="author-image rounded-4">
                                <img src="{{ asset('') }}/{{ $author->image }}" alt="{{ $author->name }}" title="{{ $author->name }}">
                            </div>
                            <div class="author-info d-flex flex-column justify-content-evenly">
                                <h5>{{ $author->name }}</h4>
                                <p class="mb-0">{{ $author->about }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

@if($articles->count() > 0 )
    <section id="latest-articles" class="py-5">
        <div class="container-lg container-md">
            <div class="row">
                <h2 class="text-center text-dark mb-4 fw-bold fs-1">@lang('custom.home.latest-news')</h2>
            </div>
            <div class="row">
                <a class="view-all-link d-flex align-items-center justify-content-end text-decoration-none pe-0" role="button" href="{{ route('front.article.index') }}">
                    <span>@lang('custom.viewall') </span>
                    <i class="fa-solid fa-angles-{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' ? 'left' : 'right'}} ms-1 fs-6"></i>
                </a>
                <div class="owl-carousel articles-carousel pe-0">
                    @foreach ($articles as $article)
                        <div class="items">
                            <div class="item-container rounded-3">
                                <div class="d-flex justify-content-center align-items-center">
                                    <a href="{{ route('front.article.show', $article) }}" class="w-100 h-100">
                                        <img src="{{ asset('storage/') }}/{{ $article->cover }}" alt="{{ $article->title }}" title="{{ $article->title }}">
                                    </a>
                                </div>
                                <div class="article-meta d-flex justify-content-between mt-1">
                                    <div class="d-flex gap-3">
                                        <span class="article-likes">
                                            <i class="fa-regular fa-thumbs-up"></i>
                                            {{ $article->likes->count() }}
                                        </span>
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
                                <div class="d-flex flex-column mt-3">
                                    <h3 class="text-dark fs-4 fw-bold mb-2">
                                        {{ $article->title }}
                                    </h3>
                                    <p class="article-contnet mb-0">
                                        {!! $article->content !!}
                                    </p>
                                </div>
                                <a href="{{ route('front.article.show', $article->slug) }}" class="read-more-link btn btn-primary d-flex align-items-center justify-content-center text-decoration-none mt-2 py-2 fs-6" role="button">
                                    <span>@lang('custom.readmore')</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif

@if(false && $blogs->count() > 0)
    <section id="latest-blogs" class="py-5 section-back">
        <div class="container-lg container-md">
            <div class="row">
                <h2 class="text-center text-dark mb-4 fw-bold fs-1">@lang('custom.home.latest-blogs')</h2>
            </div>
            <div class="row">
                <a href="{{ route('front.blog.index') }}" class="view-all-link d-flex align-items-center justify-content-end text-decoration-none pe-0" role="button">
                    <span>@lang('custom.viewall') </span>
                    <i class="fa-solid fa-angles-{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' ? 'left' : 'right'}} ms-1 fs-6"></i>
                </a>
                <div class="owl-carousel blogs-carousel pe-0">
                    @foreach ($blogs as $blog)
                        <div class="items">
                            <div class="item-container rounded-3 d-flex flex-column">
                                <div class="d-flex gap-2">
                                    <div class="d-flex justify-content-center align-items-center image-container">
                                        <img src="{{ asset($blog->user->display_image) }}">
                                    </div>
                                    <div>
                                        <h3 class="text-dark fs-3 fw-bold mb-0">
                                            {{ $blog->user->full_name }}
                                        </h3>
                                        <p class="mb-0">
                                            {{ $blog->created_at->format('d M, Y') }} 
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex flex-column mt-1">
                                    <p class="blog-contnet mb-0">
                                        {!! $blog->content !!} 
                                    </p>
                                    <a class="read-more-link d-flex align-items-center justify-content-end text-decoration-none" role="button">
                                        <span>@lang('custom.readmore')</span>
                                        <i class="fa-solid fa-angles-{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' ? 'left' : 'right'}}"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif

@endsection