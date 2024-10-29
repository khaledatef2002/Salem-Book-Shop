@extends('front.main')

@section('title', $blog->user->full_name)

@section('content')

@include('front.partials._nav', ['rounded' => 0])

<div id="blog-info" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 card border-0 d-flex gap-4 mt-3">
                @include('front.parts.blogs-list-item')
            </div>
        </div>
        <div class="row mt-4">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active border-0" aria-current="page" data-bs-toggle="list" href="#comments">@lang('custom.blogs.comments')</a>
                </li>
            </ul>
            <div class="card border-0">
                <div class="card-body">
                    <div class="tab-content p-3">
                        <div class="tab-pane fade show active" id="comments" role="tabpanel">
                            @if (Auth::check())
                                <form id="add-comment-form" class="comment-form">
                                    @csrf
                                    <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                    <p class="fw-bold fs-4 mb-0">@lang('custom.blog.add-comment')</p>
                                    <div class="d-flex gap-2">
                                        <div class="auth-image-holder d-flex align-items-center justify-content-center">
                                            <img src="{{ asset(auth()->user()->display_image) }}">
                                        </div>
                                        <textarea name="comment" class="form-control" placeholder="Leave comment..." rows="4"></textarea>
                                    </div>
                                    <button class="btn btn-primary mt-2 px-3 d-block ms-auto" type="submit">@lang('custom.send')</button>
                                </form>
                            @else
                                <p class="fw-bold fs-4 mb-0">@lang('custom.blog.add-comment')</p>
                                <a href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i> @lang('custom.blog.comment.sign-in-to-comment')</a>
                            @endif
                            @if ($blog->comments->count() > 0)
                                <div class="comment-list">
                                    <ul class="list-style-none ps-0 mb-0">
                                        @include('front.parts.single-blog-comments')
                                    </ul>
                                </div>
                                {{ $comments->links('pagination::bootstrap-4') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editBlog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('custom.blogs.form-edit-title')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-blog-form" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="blog_id">
                    <textarea class="ckEditor" name="content" placeholder="Write your post..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">@lang('custom.blogs.save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    <script src="{{ asset('front/js/single-blog.js') }}"></script>
@endsection