<div class="d-flex flex-wrap">
    @if ($blogs->count())
        @foreach ($blogs as $blog)
            <div class="border-0 items col-12 p-1">
                <div class="item-container card d-flex flex-column justify-content-between p-2 rounded-4 h-100">
                    <div class="header d-flex align-items-enter gap-2">
                        <div class="d-flex image-holder justify-content-center align-items-center">
                            <img src="{{ asset($blog->user->display_image) }}">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h3 class="text-dark mb-0">
                                <span>{{ $blog->user->full_name }}</span>
                            </h3>
                            <a class="blog-date text-dark" href="{{ route('front.blog.show', $blog) }}">{{ $blog->created_at->format('Y-m-d h:i:sa') }}</a>
                        </div>
                    </div>
                    <div class="content d-flex flex-column mt-2">
                        <p class="fw-bold fs-6 text-center mb-0">
                            <span>({{ $blog->content }})</span>
                        </p>
                    </div>
                    <div class="actions d-flex gap-2 mt-2">
                        <div class="likes-count d-flex flex-column align-items-center justify-content-end ms-2">
                            @csrf
                            <button class="d-flex align-items-center gap-2 btn btn-sm btn-{{auth()->check() && $blog->authLikes->isNotEmpty() ? '' : 'outline-'}}primary {{ auth()->check() ? 'like-blog' : 'auth-to-like' }}" 
                                data-blog-id="{{ $blog->id }}">
                                    <i class="fa-solid fa-thumbs-up"></i>
                                    <p class="mb-0"> <span class="text">@lang(auth()->check() && $blog->authLikes->isNotEmpty() ? 'custom.liked' : 'custom.like')</span> (<span class="count">{{ $blog->likes->count() }}</span>)</p>
                            </button>
                        </div>
                        <div>
                            <a class="d-flex align-items-center gap-2 btn btn-sm btn-outline-primary" href="{{ route('front.blog.show', $blog) }}">
                                <i class="fa-solid fa-comments"></i>
                                <p class="mb-0"> @lang('custom.blogs.comments') (<span>{{ $blog->comments->count() }}</span>)</p>
                            </a>
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
        {{ $blogs->appends(request()->all())->links('pagination::bootstrap-4') }}
    </div>
</div>