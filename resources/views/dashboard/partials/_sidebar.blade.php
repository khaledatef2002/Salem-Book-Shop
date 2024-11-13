@php
    $unaproavedBlogs = App\Models\Blog::where('approaved', App\ApproavedStatusType::pending->value)->count();
@endphp
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box py-2">
        <!-- Dark Logo-->
        <a href="{{ route('dashboard.index') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('storage/'. $website_settings->logo) }}" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('storage/'. $website_settings->logo) }}" alt="" height="70">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('dashboard.index') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('storage/'. $website_settings->logo) }}" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('storage/'. $website_settings->logo) }}" alt="" height="70">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::currentRouteName() ==  'dashboard.index' ? 'active' : ''}}" href="{{ route('dashboard.index') }}" role="button">
                        <i class="ri-home-3-fill"></i> <span>@lang('dashboard.home')</span>
                    </a>
                </li> <!-- End Home Menu-->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::currentRouteName() ==  'dashboard.books-category.index' ? 'active' : ''}}" href="#booksMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarUI">
                        <i class="ri-book-2-line"></i> <span>@lang('dashboard.books')</span>
                    </a>
                    <div class="collapse menu-dropdown mega-dropdown-menu" id="booksMenu">
                        <div class="row">
                            <div class="col-lg-4">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.books-category.index') }}" class="nav-link">@lang('dashboard.books.categories')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.books.index') }}" class="nav-link">@lang('dashboard.books.all-books')</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::currentRouteName() ==  'dashboard.articles-category.index' ? 'active' : ''}}" href="#articlesMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarUI">
                        <i class="ri-file-list-3-line"></i> <span>@lang('dashboard.articles')</span>
                    </a>
                    <div class="collapse menu-dropdown mega-dropdown-menu" id="articlesMenu">
                        <div class="row">
                            <div class="col-lg-4">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.articles-category.index') }}" class="nav-link">@lang('dashboard.articles.categories')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.articles.index') }}" class="nav-link">@lang('dashboard.articles.all-articles')</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::currentRouteName() ==  'dashboard.blogs.index' ? 'active' : ''}}" href="{{ route('dashboard.blogs.index') }}" role="button">
                        <i class="ri-bold"></i> <span>@lang('dashboard.blog')</span> <span class="badge bg-warning">{{ $unaproavedBlogs }}</span>
                    </a>
                </li> <!-- End Quotes Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::currentRouteName() ==  'dashboard.quote.index' ? 'active' : ''}}" href="{{ route('dashboard.quote.index') }}" role="button">
                        <i class="ri-double-quotes-l"></i> <span>@lang('dashboard.quote')</span>
                    </a>
                </li> <!-- End Quotes Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::currentRouteName() ==  'dashboard.events.index' ? 'active' : ''}}" href="{{ route('dashboard.events.index') }}" role="button">
                        <i class="ri-calendar-event-line"></i> <span>@lang('dashboard.events')</span>
                    </a>
                </li> <!-- End Quotes Menu -->
                <li class="menu-title"><span>@lang('dashboard.general')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::currentRouteName() ==  'dashboard.contacts.index' ? 'active' : ''}}" href="{{ route('dashboard.contacts.index') }}" role="button">
                        <i class="ri-contacts-line"></i> <span>@lang('dashboard.contact')</span>
                    </a>
                </li> <!-- End People Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::currentRouteName() ==  'dashboard.people.index' ? 'active' : ''}}" href="{{ route('dashboard.people.index') }}" role="button">
                        <i class="ri-team-fill"></i> <span>@lang('dashboard.people')</span>
                    </a>
                </li> <!-- End People Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::currentRouteName() ==  'dashboard.website_setting.index' ? 'active' : ''}}" href="{{ route('dashboard.website_setting.index') }}" role="button">
                        <i class="ri-tools-fill"></i> <span>@lang('dashboard.website-settings')</span>
                    </a>
                </li> <!-- End Website Settings Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::currentRouteName() ==  'dashboard.users.index' ? 'active' : ''}}" href="{{ route('dashboard.users.index') }}" role="button">
                        <i class="ri-user-fill"></i> <span>@lang('dashboard.users')</span>
                    </a>
                </li> <!-- End Website Settings Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::currentRouteName() ==  'dashboard.roles.index' ? 'active' : ''}}" href="{{ route('dashboard.roles.index') }}" role="button">
                        <i class="ri-key-2-fill"></i> <span>@lang('dashboard.roles')</span>
                    </a>
                </li> <!-- End Website Settings Menu -->
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>