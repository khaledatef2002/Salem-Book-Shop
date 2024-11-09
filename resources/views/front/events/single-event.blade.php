@extends('front.main')

@section('title', $event->title)

@section('og-image', asset($event->cover))

@section('content')

@include('front.partials._nav', ['rounded' => 0])

<div id="event-info" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-12">
                <div class="event-image-holder d-flex justify-content-center align-items-center rounded-3">
                    <img src="{{ asset('storage/' . $event->cover) }}" alt="{{ $event->title }}" title="{{ $event->title }}">
                </div>
            </div>
            <div class="col-md-7 col-12 ps-2 mt-md-0 mt-3">
                <div class="container">
                    <h2>{{ $event->title }}</h2>
                    <hr>
                    <p class="mb-2">
                        <i class="fa-solid fa-person-chalkboard me-1"></i>
                        {{ implode(',', $event->instructors()->pluck('name')->toArray()) }}
                    </p>
                    <p class="mb-2 d-flex align-items-center gap-2" id="event-info">
                        <i class="fa-solid fa-clipboard-user"></i>
                        <span class="counter">{{ $event->attendants->count() }}</span>
                        <span id="auth-attendance-info" style="display: {{ Auth::check() && $event->authAttendants->count() ? 'block' : 'none' }}">(@lang('custom.events.attended') <i class="fa-solid fa-check text-success"></i>)</span>
                    </p>
                    @if ($event->date < now())
                        <div class="d-flex flex-column align-items-center mb-3" style="width: fit-content">
                            <span class="fw-bold fs-1">{{ number_format($event->avg_review, 1) }}</span>
                            <span>
                                @for ($i = 0; $i < round($event->avg_review); $i++)
                                    <i class="fa-solid fa-star text-warning"></i>
                                @endfor
                                @for ($i = 0; $i < 5 - round($event->avg_review); $i++)
                                    <i class="fa-regular fa-star"></i>
                                @endfor
                            </span>
                        </div>
                        <p class="mb-2">
                            <i class="fa-solid fa-message"></i> {{ $event->reviews->count() }} @lang('custom.reviews')
                        </p>
                    @endif
                    <p>
                        <i class="fa-solid fa-calendar-days"></i> <bdi>{{ $event->date->format('Y, M d h:ia') }}</bdi>
                    </p>
                    <p>
                        {{ $event->description }}
                    </p>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="container">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active border-0" aria-current="page" data-bs-toggle="list" href="#attendance">@lang('custom.events.attendance')</a>
                    </li>
                    @if ($event->date < now())
                        <li class="nav-item">
                            <a class="nav-link border-0" aria-current="page" data-bs-toggle="list" href="#reviews">@lang('custom.reviews')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link border-0" aria-current="page" data-bs-toggle="list" href="#media">@lang('custom.events.media')</a>
                        </li>
                    @endif
                </ul>
                <div class="card border-0">
                    <div class="card-body">
                        <div class="tab-content p-3">
                            <div class="tab-pane active show" id="attendance" role="tabpanel">
                                @include('front.parts.events-attendance')
                            </div>
                            @if ($event->date < now())
                                <div class="tab-pane" id="reviews" role="tabpanel">
                                    @include('front.parts.events-reviews')
                                </div>
                                <div class="tab-pane" id="media" role="tabpanel">
                                    @include('front.parts.events-media')
                                </div>
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
    <script src="{{ asset('front/js/single-event.js') }}"></script>
@endsection