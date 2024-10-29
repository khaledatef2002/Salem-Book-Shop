<div class="d-flex flex-wrap">
    @if ($blogs->count())
        @foreach ($blogs as $blog)
            @include('front.parts.blogs-list-item', $blog)
        @endforeach
    @else
        <h3 class="mx-auto mt-2">@lang('custom.no-result')</h3>
    @endif
</div>
<div class="container-fluid px-1 mb-3 mt-4">
    <div class="row px-3">
        {{ $blogs->appends(request()->all())->links('pagination::bootstrap-4') }}
    </div>
</div>