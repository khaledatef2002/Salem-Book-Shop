@foreach ($article->comments as $key => $comment)
    <div>
        <hr>
        <li class="d-flex gap-2 comment">
            <div class="user_image d-flex justify-content-center align-items-center">
                <img src="{{ $comment->user->display_image }}" alt="">
            </div>
            <div class="comment-info w-100">
                <div class="header d-flex flex-fill align-items-center justify-content-between">
                    <p class="mb-0 fw-bold">{{ $comment->user->full_name }}</p>
                    @if (Auth::check() && $comment->user_id == Auth::user()->id)
                    <div class="actions ms-auto" style="display: flex;">
                        <form id="delete-auth-comment-form" onsubmit="delete_review(event, this, {{ $comment->id }})">
                            @csrf
                            @method('DELETE')
                            <button class="fa-solid fa-trash-can text-danger fs-5" type="submit"></button>
                        </form>
                        <button onclick="edit_comment(this)"  class="fa-solid fa-pen-to-square text-success fs-5" type="submit"></button>
                    </div>
                    @endif
                </div>
                @if (Auth::check() && $comment->user_id == Auth::user()->id)
                    <form class="edit-comment-form" style="display: none">
                        @csrf
                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                        <textarea name="comment" class="form-control" placeholder="Leave comment..." rows="4"></textarea>
                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-primary mt-2 px-3 d-block" type="submit">@lang('custom.save')</button>
                            <button class="cancel-edit-button btn btn-secondary mt-2 px-3 d-block" type="button">@lang('custom.cancel')</button>
                        </div>
                    </form>                
                @endif
                <p class="mb-0 comment">{{ $comment->comment }}</p>
            </div>
        </li>
    </div>
@endforeach