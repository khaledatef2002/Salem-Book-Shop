<nav class="navbar navbar-expand-lg bg-light rounded-4 px-md-3">
    <div class="container-fluid d-flex justify-content-start">
        <div class="d-flex flex-lg-grow-0 flex-fill">
            <div class="d-flex flex-fill justify-content-between">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="{{ asset('front') }}/imgs/logo.png" width="60px">
                </a>
                <button class="navbar-toggler border-0 ms-auto" type="button" data-bs-toggle="collapse" data-bs-target=".navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>
        <div class="collapse navbar-collapse navbarSupportedContent ms-2">
            <ul class="navbar-nav mb-2 mb-lg-0 d-flex gap-4">
                <li class="nav-item text-center">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-expanded="false">
                      Books
                    </a>
                    <div class="dropdown-menu border-0">
                        @foreach ($book_categories as $category)
                            <a class="dropdown-item" href="#">{{ $category->name }}</a>
                        @endforeach
                    </div>
                  </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="#">Quotes</a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="#">Events</a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="#">Blogs</a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="#">News</a>
                </li>
            </ul>
        </div>
        <div class="collapse navbar-collapse navbarSupportedContent text-center d-lg-flex justify-content-end">
            <div class="mb-lg-0 mb-2 d-flex align-items-center">
                <a href="http://" class="text-decoration-none me-2 fs-5 ms-lg-0 ms-4" id="log-in-button">Log in</a>
                <a href="http://" class="btn btn-primary rounded-5 px-4 py-2 fw-bold ms-2" id="sign-up-button">Sign Up</a>
            </div>
            <img src="{{ asset('front') }}/imgs/ar.svg" height="25" class="ms-3 rounded-2" role="button">
        </div>
    </div>
</nav>