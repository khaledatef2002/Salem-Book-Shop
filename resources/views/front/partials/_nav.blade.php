<nav class="navbar navbar-expand-lg bg-light rounded-{{ $rounded ?? '4' }} px-md-3">
    <div class="container-fluid d-flex justify-content-start">
        <div class="d-flex flex-lg-grow-0 flex-fill">
            <div class="d-flex flex-fill justify-content-between">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('front.index') }}">
                    <img src="{{ asset('front') }}/imgs/logo.png" width="60px">
                </a>
                <button class="navbar-toggler border-0 ms-auto" type="button" data-bs-toggle="collapse" data-bs-target=".navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
        <div class="collapse navbar-collapse navbarSupportedContent ms-2">
            <ul class="navbar-nav mb-2 mb-lg-0 d-flex gap-md-4 gap-2">
                <li class="nav-item text-center">
                    <a class="nav-link active" aria-current="page" href="{{ route('front.index') }}">@lang('custom.home')</a>
                </li>
                <li class="nav-item dropdown text-center">
                    <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
                      @lang('custom.books')
                    </a>
                    <div class="dropdown-menu border-0">
                        @foreach ($book_categories as $category)
                            <a class="dropdown-item" href="{{ route('front.book.index', ['category_id' => $category->id]) }}">{{ $category->name }}</a>
                        @endforeach
                        <hr class="my-1">
                        <a class="dropdown-item" href="{{ route('front.book.index') }}">@lang('custom.all-books')</a> 
                    </div>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="{{ route('front.quote.index') }}">@lang('custom.quotes')</a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="{{ route('front.event.index') }}">@lang('custom.events')</a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="{{ route('front.blog.index') }}">@lang('custom.blogs')</a>
                </li>
                <li class="nav-item dropdown text-center">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" role="button">@lang('custom.news')</a>
                    <div class="dropdown-menu border-0">
                        @foreach ($news_categories as $category)
                            <a class="dropdown-item" href="{{ route('front.article.index', ['article_id' => $category->id]) }}">{{ $category->name }}</a>
                        @endforeach
                        <hr class="my-1">
                        <a class="dropdown-item" href="{{ route('front.article.index') }}">@lang('custom.all-articles')</a> 
                    </div>
                </li>
            </ul>
        </div>
        <div class="collapse navbar-collapse navbarSupportedContent text-center d-lg-flex justify-content-end">
            @if (Auth::check())
                <div class="auth-list mb-2 nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user"></i>
                    </a>
                    <div class="dropdown-menu border-0 px-2">
                        <div class="user-info d-flex flex-column align-items-center">
                            <div class="user-image">
                                <img src="{{ Auth::user()->display_image }}">
                            </div>
                            <p class="mb-0 fw-bold">{{ ucfirst(Auth::user()->full_name) }}</p>
                            <span>{{ Auth::user()->email }}</span>
                        </div>
                        <hr class="my-2">
                        <a class="dropdown-item" href="{{ route('front.profile') }}"><i class="fa-solid fa-user"></i> @lang('custom.profile')</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item"><i class="fa-solid fa-right-from-bracket"></i> @lang('custom.logout')</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="mb-lg-0 mb-2 d-flex align-items-center justify-content-center">
                    <a href="{{ route('login') }}" class="text-decoration-none me-2 fs-5 ms-lg-0 ms-4" id="log-in-button">@lang('custom.login')</a>
                    <a href="{{ route('register') }}" class="btn btn-primary rounded-5 px-4 py-2 fw-bold ms-2" id="sign-up-button">@lang('custom.signup')</a>
                </div>
            @endif
            @if (LaravelLocalization::getCurrentLocale() == 'ar')
                <a href="{{ LaravelLocalization::getLocalizedURL('en') }}"><img src="{{ asset('front') }}/imgs/en.svg" height="25" class="ms-md-3 rounded-2" role="button"></a>
            @else
                <a href="{{ LaravelLocalization::getLocalizedURL('ar') }}"><img src="{{ asset('front') }}/imgs/ar.svg" height="25" class="ms-md-3 rounded-2" role="button"></a>
            @endif
        </div>
    </div>
</nav>