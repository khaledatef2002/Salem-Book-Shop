<div class="container">
    <div class="card d-flex gap-2 flex-column align-items-center my-5 border-0 p-3">
        <i class="fa-solid fa-check-double text-success fs-1"></i>
        <p class="mb-0 fs-1">@lang('custom.blogs.this-blog-is-no-longer-avillable')</p>
        <a href="{{ route('front.blog.index') }}">@lang('custom.return')</a>
    </div>
</div>

<style>
body {
    padding-right: 0px;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
</style>