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
                </li> <!-- Home -->

                <li class="menu-title"><span>Website</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ Route::currentRouteName() ==  'dashboard.website_setting.index' ? 'active' : ''}}" href="{{ route('dashboard.website_setting.index') }}" role="button">
                        <i class="ri-tools-fill"></i> <span>@lang('dashboard.website-settings')</span>
                    </a>
                </li> <!-- end Dashboard Menu -->
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>