@extends('front.main')

@section('title', $book->title)

@section('og-image', asset($book->images->first()->url))

@if ($book->description)
    @section('description', $book->description)
@endif

@section('keywords', $book->keywords)

@section('content')

@include('front.partials._nav', ['rounded' => 0])

<div id="book-info" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-5 col-11">
                <div class="owl-carousel book-carousel pe-0">
                    @foreach ($book->images as $image)
                        <div class="book-image-holder d-flex justify-content-center align-items-center">
                            <img src="{{ asset('storage/' . $image->url) }}" alt="{{ $book->title }}" title="{{ $book->title }}">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-9 col-md-7 col-11 ps-md-4 mb-md-0 mb-5">
                <h2>{!! !$book->authUnlocked() ? '<i class="fas fa-lock fs-4" id="title_lock_icon"></i>' : '' !!} {{ $book->title }}</h2>
                <hr>
                <p>
                    <i class="fa-solid fa-pen-nib"></i> {{ $book->author->name }}
                </p>
                <p>
                    <a class="text-decoration-none" href="{{ route('front.book.index', ['category_id' => $book->category->id]) }}"><i class="fa-solid fa-layer-group"></i> {{ $book->category->name }}</a>
                </p>
                <p>
                    <i class="fa-solid fa-message"></i> {{ $book->reviews->count() }} @lang('custom.reviews')
                </p>
                <div class="d-flex flex-column align-items-center mb-3" style="width: fit-content">
                    <span class="fw-bold fs-1">{{ number_format($book->avg_review, 1) }}</span>
                    <span>
                        @for ($i = 0; $i < round($book->avg_review); $i++)
                            <i class="fa-solid fa-star text-warning"></i>
                        @endfor
                        @for ($i = 0; $i < 5 - round($book->avg_review); $i++)
                            <i class="fa-regular fa-star"></i>
                        @endfor
                    </span>
                </div>
                @if ($book->authUnlocked())
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#book-read">@lang('custom.books.read')</a>
                    @if($book->downloadable)
                        <a href="{{ route('front.books.download', $book) }}" class="btn btn-success" target="_blank">@lang('custom.books.download')</a>
                    @else
                        <p>@lang('custom.books.no-download')</p>
                    @endif
                @elseif ($book->authPendingRequest())
                    <div class="mt-3">
                        <p class="mb-0 fs-6 text-muted">You have already a pending request</p>
                        <button class="btn btn-danger px-3" onclick="cancel_request_unlock_book(this, {{ $book->id }})">Cancel Request</button>
                    </div>
                @else
                    <button class="btn btn-primary px-3" onclick="request_unlock_book(this, {{ $book->id }})"><i class="fas fa-unlock-alt pe-1"></i> Request Unlock</button>    
                @endif
            </div>
        </div>
        @if ($book->description)
            <div class="row mt-2">
                <p class="fw-bold mb-0">@lang('dashboard.description'):</p>
                <p>{{ $book->description }}</p>
            </div>
        @endif
        <div class="row mt-2">
            <div class="container">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active border-0" aria-current="page" data-bs-toggle="list" href="#reviews">@lang('custom.reviews')</a>
                    </li>
                </ul>
                <div class="card border-0">
                    <div class="card-body">
                        <div class="tab-content p-3">
                            <div class="tab-pane fade show active" id="reviews" role="tabpanel">
                                @if (Auth::check())
                                    <form id="add-review-form" class="review-form" style="display: {{ $book->authReview->count() ? 'none' : 'block' }}">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <p class="fw-bold fs-4 mb-0">@lang('custom.review.tell-others')</p>
                                        <p class="mb-0">@lang('custom.review.tell-others')</p>
                                        <div class="stars my-2">
                                            <i class="fa-regular fa-star fs-4" data-id="1" role="button"></i>
                                            <i class="fa-regular fa-star fs-4" data-id="2" role="button"></i>
                                            <i class="fa-regular fa-star fs-4" data-id="3" role="button"></i>
                                            <i class="fa-regular fa-star fs-4" data-id="4" role="button"></i>
                                            <i class="fa-regular fa-star fs-4" data-id="5" role="button"></i> 
                                        </div>
                                        <textarea name="review_text" class="form-control" placeholder="Leave comment..." rows="4"></textarea>
                                        <button class="btn btn-primary mt-2 px-3 d-block ms-auto" type="submit">@lang('custom.send')</button>
                                    </form>
                                    <div id="auth-review" class="review" style="display: {{ $book->authReview->count() ? 'block' : 'none' }}">
                                        @include('front.parts.book-auth-review', ['review' => $book->authReview->first()])
                                    </div>
                                    <form id="edit-review-form" class="review-form" style="display: none">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <p class="fw-bold fs-4 mb-0">@lang('custom.book.review.rate-this-book')</p>
                                        <p class="mb-0">@lang('custom.book.review.tell-others')</p>
                                        <div class="stars my-2">
                                            <i class="fa-regular fa-star fs-4" data-id="1" role="button"></i>
                                            <i class="fa-regular fa-star fs-4" data-id="2" role="button"></i>
                                            <i class="fa-regular fa-star fs-4" data-id="3" role="button"></i>
                                            <i class="fa-regular fa-star fs-4" data-id="4" role="button"></i>
                                            <i class="fa-regular fa-star fs-4" data-id="5" role="button"></i> 
                                        </div>
                                        <textarea name="review_text" class="form-control" placeholder="Leave comment..." rows="4"></textarea>
                                        <div class="d-flex justify-content-end gap-2">
                                            <button class="btn btn-primary mt-2 px-3 d-block" type="submit">@lang('custom.save')</button>
                                            <button class="btn btn-secondary mt-2 px-3 d-block cancel_edit_review" type="button">@lang('custom.cancel')</button>
                                        </div>
                                    </form>
                                @else
                                    <p class="fw-bold fs-4 mb-0">@lang('custom.book.review.rate-this-book')</p>
                                    <a href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i> @lang('custom.book.review.sign-in-to-rate')</a>
                                @endif
                                @if ($reviews->count() > 0)
                                    <div class="reviews-list">
                                        <ul class="list-style-none ps-0 mb-0">
                                            @foreach ($reviews as $key => $review)
                                                @if ($review->user_id != Auth::user()?->id)
                                                    <hr>
                                                    <li class="d-flex flex-column gap-2 review">
                                                        <div>
                                                            <div class="user-info d-flex align-items-center gap-3 mb-1">
                                                                <div class="user_image d-flex justify-content-center align-items-center">
                                                                    <img src="{{ $review->user->display_image }}" alt="{{ $review->user->full_name }} @lang('dashboard.person.image')" title="{{ $review->user->full_name }} @lang('dashboard.person.image')">
                                                                </div>
                                                                <p class="mb-0 fw-bold">{{ $review->user->full_name }}</p>
                                                            </div>
                                                            <div class="meta-data d-flex gap-3">
                                                                <p class="mb-0">
                                                                    @for ($i = 0; $i < round($review->review_star); $i++)
                                                                        <i class="fa-solid fa-star text-warning"></i>
                                                                    @endfor
                                                                    @for ($i = 0; $i < 5 - round($review->review_star); $i++)
                                                                        <i class="fa-regular fa-star"></i>
                                                                    @endfor
                                                                    ({{ $review->review_star }})
                                                                </p>
                                                                <p class="mb-0">{{ $review->created_at->format('Y/m/d')}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="review-info">
                                                            <p class="fs-4 mb-0">{{ $review->review_text }}</p>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    {{ $reviews->links('pagination::bootstrap-4') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="book-read" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body p-0 vh-100">
            @for ($i = 1; $i <= $pagesCount; $i++)
                <div class="page d-flex justify-content-center align-items-center" data-page="{{ $i }}">
                    <div class="spinner-grow text-primary" role="status"></div>
                </div>
            @endfor
            <div class="pages-navigator">
                <button class="btn text-white px-3" data-bs-dismiss="modal" aria-label="Close">X</button>
                <input type="number" value="1">
                <span>/{{ $pagesCount }}</span>
            </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('custom-js')
    <script>
        let book_id = {{ $book->id }}
        let pages_count = {{ $pagesCount }}
        let csrf = "{{ csrf_token() }}"
    </script>
    <script src="{{ asset('front/js/single-book.js') }}?id=19"></script>
@endsection