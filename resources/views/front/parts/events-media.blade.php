<div class="container d-flex flex-wrap">
    @foreach ($event->media as $media)
        <div class="col-lg-3 col-md-6 col-12 p-2">
            <div class="event-media-container d-flex justify-content-center align-items-center rounded-3 position-relative">
                <div class="zoom-over">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <img src="{{ asset('storage/' . $media->source) }}" alt="">
            </div>
        </div>
    @endforeach
</div>

@include('front.parts.events-media-zoom')