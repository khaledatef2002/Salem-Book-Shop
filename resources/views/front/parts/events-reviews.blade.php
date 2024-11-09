@if (Auth::check())
    @if ($event->authAttendants->count())
        <form id="add-review-form" class="review-form" style="display: {{ $event->authReview->count() ? 'none' : 'block' }}">
            @csrf
            <input type="hidden" name="seminar_id" value="{{ $event->id }}">
            <p class="fw-bold fs-4 mb-0">@lang('custom.event.review.rate-this-event')</p>
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
        <div id="auth-review" class="review" style="display: {{ $event->authReview->count() ? 'block' : 'none' }}">
            @include('front.parts.events-auth-review', ['review' => $event->authReview->first()])
        </div>
        <form id="edit-review-form" class="review-form" style="display: none">
            @csrf
            <input type="hidden" name="seminar_id" value="{{ $event->id }}">
            <p class="fw-bold fs-4 mb-0">@lang('custom.event.review.rate-this-event')</p>
            <p class="mb-0">@lang('custom.event.review.tell-others')</p>
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
                <button class="btn btn-secondary mt-2 px-3 d-block cancel_edit_event_review" type="button">@lang('custom.cancel')</button>
            </div>
        </form>
    @endif
@else
    <p class="fw-bold fs-4 mb-0">@lang('custom.event.review.rate-this-event')</p>
    <a href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i> @lang('custom.event.review.sign-in-to-rate')</a>
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
                                    <img src="{{ $review->user->display_image }}" alt="{{ $review->user->full_name }}" title="{{ $review->user->full_name }}">
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
    {{ $reviews->appends(['attendance_page' => request('attendance_page')])->links('pagination::bootstrap-4') }}
@endif