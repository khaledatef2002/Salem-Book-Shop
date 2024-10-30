<div class="d-flex flex-wrap px-2">
    @if ($articles->count())
        @foreach ($articles as $article)
            <div class="items col-lg-4 col-12">
                <div class="item-container">
                    <div class="d-flex justify-content-center align-items-center rounded-3">
                        <img src="{{ asset('front') }}/{{ $article->cover }}">
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
                        <h3 class="text-dark fs-3 fw-bold mb-2">
                            {{ $article->title }}
                        </h3>
                        <p class="article-contnet mb-0">
                            {{ $article->content }}
                        </p>
                    </div>
                    <a href="{{ route('front.article.show', $article) }}" class="read-more-link d-flex align-items-center justify-content-end text-decoration-none" role="button">
                        <span>@lang('custom.readmore')</span>
                        <i class="fa-solid fa-angles-{{ LaravelLocalization::getCurrentLocaleDirection() == 'rtl' ? 'left' : 'right'}}"></i>
                    </a>
                </div>
            </div>
        @endforeach
    @else
        <h3 class="mx-auto mt-2">@lang('custom.no-result')</h3>
    @endif
</div>
<div class="container-fluid px-1 mb-3 mt-4">
    <div class="row px-3">
        {{ $articles->appends(request()->all())->links('pagination::bootstrap-4') }}
    </div>
</div>