<div class="d-flex flex-wrap">
    @if ($books->count())
        @foreach ($books as $book)
            <div class="items col-xl-3 col-lg-4 col-sm-6 col-xs-12 p-1">
                <a href="{{ route('front.book.show', $book) }}" class="text-decoration-none" class="d-block flex-wrap p-0 m-0">
                    <div class="item-container d-flex flex-column justify-content-between px-2 rounded-4 h-100">
                        <h3 class="fs-6 text-center text-dark fw-bold flex-fill d-flex align-items-center justify-content-center">{{ $book->title }}</h3>
                        <div>
                            <div class="d-flex justify-content-center align-items-center">
                                <img src="{{ asset($book->images->first()->url) }}">
                            </div>
                            <div class="content d-flex flex-column mt-2">
                                <h3 class="text-dark fs-6 text-center mb-0">
                                    <i class="fa-solid fa-feather"></i>
                                    <span>{{ $book->author->name }}</span>
                                </h3>
                                <p class="fw-bold fs-6 text-center mb-0">
                                    <i class="fa-regular fa-star"></i>
                                    <span>({{ $book->avg_review }})</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    @else
        <h3 class="mx-auto mt-2">@lang('custom.no-result')</h3>
    @endif
</div>
<div class="container-fluid px-1 mb-3 mt-4">
    <div class="row px-3">
        {{ $books->appends(request()->all())->links('pagination::bootstrap-4') }}
    </div>
</div>