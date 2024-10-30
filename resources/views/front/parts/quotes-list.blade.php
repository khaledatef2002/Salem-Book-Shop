<div class="d-flex flex-wrap">
    @if ($quotes->count() > 0)
        @foreach ($quotes as $quote)
            <div class="items col-12 p-1">
                <div class="item-container d-flex flex-column justify-content-between px-2 rounded-4 h-100">
                    <div class="card border rounded-3">
                        <div class="d-flex flex-lg-row flex-column p-2 gap-lg-0 gap-3">
                            <div class="author d-flex flex-column align-items-center justify-content-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <img src="{{ asset($quote->author->image) }}" class="rounded-3">
                                </div>
                                <span>{{ $quote->author->name }}</span>
                            </div>
                            <div class="content d-flex flex-column ms-3 flex-fill">
                                <h3 class="fs-6 fw-bold flex-fill d-flex gap-lg-0 gap-3 flex-lg-row flex-column justify-content-start align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-quote-left fs-3 me-3"></i> 
                                        {{ $quote->title }}
                                    </div>
                                    <div class="likes-count d-flex flex-fill flex-column align-items-center justify-content-end ms-2">
                                        @csrf
                                        <button class="btn btn-sm btn-{{auth()->check() && $quote->authLikes->isNotEmpty() ? '' : 'outline-'}}primary {{ auth()->check() ? 'like-quote' : 'auth-to-like'}}" data-quote-id="{{ $quote->id }}"><i class="fa-solid fa-thumbs-up"></i> <span class="text"> @lang(auth()->check() && $quote->authLikes->isNotEmpty() ? 'custom.liked' : 'custom.like')</span> (<span class="count">{{ $quote->likes_count }}</span>)</button>
                                    </div>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <h3 class="mx-auto mt-2">@lang('custom.no-result')</h3>
    @endif
</div>
<div class="container-fluid px-1 mb-3 mt-4">
    <div class="row px-3">
        {{ $quotes->appends(request()->all())->links('pagination::bootstrap-4') }}
    </div>
</div>