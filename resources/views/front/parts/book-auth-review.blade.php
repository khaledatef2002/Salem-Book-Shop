@if ($review)
    <div>
        <div class="user-info d-flex align-items-center gap-3 mb-1">
            <div class="user_image d-flex justify-content-center align-items-center">
                <img src="{{ Auth::user()->display_image }}" alt="{{ Auth::user()->full_name }} @lang('dashboard.person.image')" title="@lang('custom.you')">
            </div>
            <p class="mb-0 fw-bold">{{ Auth::user()->full_name }} (@lang('custom.you'))</p>
            <div class="actions ms-auto d-flex gap-3">
                <form id="delete-auth-review-form" onsubmit="delete_review(event, this, {{ $review->book->id }})">
                    @csrf
                    @method('DELETE')
                    <button class="fa-solid fa-trash-can text-danger fs-5" type="submit"></button>
                </form>
                <form id="delete-auth-review-form" onsubmit="edit_review(event, this, {{ $review->book->id }})">
                    <button class="fa-solid fa-pen-to-square text-success fs-5" type="submit"></button>
                </form>
            </div>
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
@endif