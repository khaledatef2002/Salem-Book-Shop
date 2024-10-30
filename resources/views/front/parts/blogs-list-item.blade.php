<div class="border-0 items col-12 p-1">
    <div class="item-container card border-0 d-flex flex-column justify-content-between p-2 rounded-3 h-100">
        <div class="header d-flex align-items-enter gap-2">
            <div class="d-flex image-holder justify-content-center align-items-center">
                <img src="{{ asset($blog->user->display_image) }}">
            </div>
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="d-flex flex-column justify-content-center">
                    <h3 class="text-dark mb-0">
                        <span>{{ $blog->user->full_name }}</span>
                    </h3>
                    <a class="blog-date text-dark" href="{{ route('front.blog.show', $blog) }}">{{ $blog->created_at->format('Y-m-d h:i:sa') }}</a>
                </div>
                @if (Auth::check() && $blog->user_id == Auth::user()->id)
                    <div class="actions" style="display: flex;">
                        <form id="delete-auth-blog-form" onsubmit="delete_blog(event, this, {{ $blog->id }})">
                            @csrf
                            @method('DELETE')
                            <button class="fa-solid fa-trash-can text-danger fs-5" type="submit"></button>
                        </form>
                        <button onclick="edit_blog(event, this, {{ $blog->id }})"  class="fa-solid fa-pen-to-square text-success fs-5" type="submit"></button>
                    </div>
                @endif
            </div>
        </div>
        <div class="content d-flex flex-column mt-2 px-2">
            <p class="fw-bold fs-6 mb-0">
                <span>{!! $blog->content !!}</span>
                @if ($blog->isTruncated)
                    <a class="blog-readmore" href="{{ route('front.blog.show', $blog) }}">@lang('custom.readmore')</a>
                @endif
            </p>
        </div>
        <div class="d-flex gap-2 mt-2">
            <div class="likes-count d-flex flex-column align-items-center justify-content-end ms-2">
                @csrf
                <button {{ auth()->check() ? "onclick=like_action(this)" : '' }} class="d-flex align-items-center gap-2 btn btn-sm btn-{{auth()->check() && $blog->authLikes->isNotEmpty() ? '' : 'outline-'}}primary {{ auth()->check() ? '' : 'auth-to-like' }}" 
                    data-blog-id="{{ $blog->id }}">
                        <i class="fa-solid fa-thumbs-up"></i>
                        <p class="mb-0"> <span class="text">@lang(auth()->check() && $blog->authLikes->isNotEmpty() ? 'custom.liked' : 'custom.like')</span> (<span class="count">{{ $blog->likes->count() }}</span>)</p>
                </button>
            </div>
            <div>
                <a class="d-flex align-items-center gap-2 btn btn-sm btn-outline-primary comment_button" href="{{ route('front.blog.show', $blog) }}">
                    <i class="fa-solid fa-comments"></i>
                    <p class="mb-0"> @lang('custom.blogs.comments') (<span>{{ $blog->comments->count() }}</span>)</p>
                </a>
            </div>
        </div>
    </div>
</div>