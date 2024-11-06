<div class="d-flex flex-wrap">
    @if ($events->count())
        @foreach ($events as $event)
            <div class="items col-12 p-1">
                    <div class="card border-0">
                        <div class="card-body d-flex flex-lg-row flex-column gap-lg-3">
                            <div class="event-image rounded-3 d-flex justify-content-center align-items-center">
                                <img src="{{ asset('storage/' . $event->cover) }}" alt="">
                            </div>
                            <div class="event-content flex-fill py-2 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="event-content-header d-flex justify-content-between align-items-center">
                                        <h2 class="fs-4 text-center text-dark fw-bold">{{ $event->title }}</h2>
                                        <span class="time fw-bold">
                                            <bdi>{{ $event->date->format("Y, M d h:ia") }}</bdi>
                                            @if ($event->date < now())
                                                (<i class="fa-solid fa-check-double text-success"></i>)
                                            @else
                                                <i class="fa-solid fa-hourglass-half text-warning"></i>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="event-description">
                                        {{ $event->description }}
                                    </div>
                                </div>
                                <div>
                                    <div class="tags d-flex flex-wrap align-items-end column-gap-3">
                                        <div class="instructors">
                                            <i class="fa-solid fa-person-chalkboard me-1"></i>
                                            {{ implode(',', $event->instructors()->pluck('name')->toArray()) }}
                                        </div>
                                        <div class="attendance">
                                            <i class="fa-solid fa-clipboard-user"></i>
                                            {{ $event->attendants->count() }}
                                            @if (Auth::check() && $event->authAttendants->count())
                                                (@lang('custom.events.attended') <i class="fa-solid fa-check text-success"></i>)
                                            @endif
                                        </div>
                                        <div class="reviews">
                                            <i class="fa-solid fa-message"></i>
                                            {{ $event->reviews->count() }}
                                        </div>
                                        <div class="d-flex flex-fill justify-content-end align-items-center">
                                            <a href="{{ route('front.event.show', $event) }}" class="text-decoration-none">Details <i class="fa-solid fa-angles-right"></i></a>
                                        </div>
                                    </div>
                                </div>
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
        {{ $events->appends(request()->all())->links('pagination::bootstrap-4') }}
    </div>
</div>