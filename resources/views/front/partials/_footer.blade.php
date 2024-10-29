<footer class="pt-5">
    <div class="container-lg container-md">
        <div class="row text-white">
            <div class="col-md-3 col-12 d-flex flex-column align-items-md-start align-items-center px-3">
                <div class="website d-flex align-items-center gap-2 mb-3">
                    <img src="{{ asset('front') }}/imgs/logo-white.png" alt="" width="40">
                    <p class="mb-0">{{ $website_settings->site_title }}</p>
                </div>
                <p class="mb-4">@lang('custom.footer.description')</p>
            </div>
            <hr class="d-md-none d-block">
            <div class="col-md-3 col-6 d-flex flex-column px-3">
                <p class="fw-bold mb-3">@lang('custom.footer.pages')</p>
                <ul class="list-style-none ps-0 d-flex flex-column gap-3">
                    <li><a href="{{ route('front.index') }}" class="text-decoration-none text-white">@lang('custom.home')</a></li>
                    <li><a href="{{ route('front.about') }}" class="text-decoration-none text-white">@lang('custom.about-us')</a></li>
                    <li><a href="{{ route('front.contact') }}" class="text-decoration-none text-white">@lang('custom.contact-us')</a></li>
                    <li><a href="{{ route('front.article.index') }}" class="text-decoration-none text-white">@lang('custom.news')</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-6 d-flex flex-column px-3">
                <p class="fw-bold mb-3">@lang('custom.footer.services')</p>
                <ul class="list-style-none ps-0 d-flex flex-column gap-3">
                    <li><a href="{{ route('front.book.index') }}" class="text-decoration-none text-white">@lang('custom.books')</a></li>
                    <li><a href="{{ route('front.quote.index') }}" class="text-decoration-none text-white">@lang('custom.quotes')</a></li>
                    <li><a href="{{ route('front.event.index') }}" class="text-decoration-none text-white">@lang('custom.events')</a></li>
                    <li><a href="{{ route('front.blog.index') }}" class="text-decoration-none text-white">@lang('custom.blogs')</a></li>
                </ul>
            </div>
            <hr class="d-md-none d-block">
            <div class="col-md-3 col-12 d-flex flex-column align-items-md-start align-items-center px-3">
                <p class="fw-bold mb-3 d-flex">@lang('custom.footer.social-media')</p>
                <ul class="list-style-none ps-0 d-flex flex-wrap gap-3 justify-content-between">
                    <a href="https://www.facebook.com/share/55bLCo35RVzNmnVD/?mibextid=qi2Omg" class="text-decoration-none">
                        <li class="bg-white rounded-3 px-3 py-2 d-flex align-items-center justify-content-center">
                            <i class="fa-brands fa-facebook-f text-dark fs-5"></i>
                        </li>
                    </a>
                    <a href="https://youtube.com/@salembookshop?si=VLAGLp_xqL0ed1wC" class="text-decoration-none">
                        <li class="bg-white rounded-3 px-3 py-2 d-flex align-items-center justify-content-center">
                            <i class="fa-brands fa-youtube text-dark fs-5"></i>
                        </li>
                    </a>
                    <a href="https://www.tiktok.com/@salem.bookshop?_t=8opwsYlDs1Z&_r=1" class="text-decoration-none">
                        <li class="bg-white rounded-3 px-3 py-2 d-flex align-items-center justify-content-center">
                            <i class="fa-brands fa-tiktok text-dark fs-5"></i>
                        </li>
                    </a>
                    <a href="https://www.instagram.com/salembookshop?igsh=cGdzcHZzcWozdnN2" class="text-decoration-none">
                        <li class="bg-white rounded-3 px-3 py-2 d-flex align-items-center justify-content-center">
                            <i class="fa-brands fa-instagram text-dark fs-5"></i>
                        </li>
                    </a>
                </ul>
            </div>
        </div>
        <hr>
        <div class="copyrights d-flex justify-content-center">
            <p class="text-white">@lang('custom.footer.copyright') &copy; 2024 {{ $website_settings->site_title }}.</p>
        </div>
    </div>
</footer>

<div class="whatsapp-contact">
    <img src="{{ asset('front') }}/imgs/whatsapp.png">
</div>