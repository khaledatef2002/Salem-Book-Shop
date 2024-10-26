@extends('front.main')

@section('title', __('custom.all-events'))

@section('content')

@include('front.partials._nav', ['rounded' => 0])

<div id="page-header" class="py-5">
    <div class="container d-flex">
        <div>
            <img src="{{ asset('front/imgs/events.png') }}" height="120">
        </div>
        <div class="d-flex flex-column align-items-start justify-content-evenly ps-5">
            <span class="badge text-dark fw-bold">{{ $website_settings->site_title }}</span>
            <h2>@lang('custom.events.list-of-all')</h2>
        </div>
    </div>
</div>

<div id="events-page-body">
    <div class="container d-flex">
        <div class="col-3 py-5">
            <div class="card border-0">
                <div class="card-body py-2">
                    <p class="fw-bold">@lang('custom.status')</p>
                    <ul class="list-style-none ps-0 mb-0">
                        <li class="mb-2">
                            <div class="input-group">
                                <input name="status" id="comming" type="checkbox" class="me-2" value="comming" onclick="events_filters()" role="button">
                                <label for="comming" role="button">Comming</label>
                            </div>
                        </li>
                        <li class="mb-2">
                            <div class="input-group">
                                <input name="status" id="ended" type="checkbox" class="me-2" value="ended" onclick="events_filters()" role="button">
                                <label for="ended" role="button">Ended</label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-9 d-flex flex-wrap py-5">
            <div class="container-fluid px-1 mb-3">
                <div class="row px-3">
                    <div class="bg-white rounded-2 py-2">
                        <form action="{{ url()->current() }}" method="get" class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                            <div class="search-bar d-flex">
                                <input type="text" class="form-control me-1" placeholder="Search..." name="search" onkeyup="events_filters()">
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <div class="sort d-flex align-items-center">
                                    <p class="mb-0 me-1 fw-bold">@lang('custom.sort')</p>
                                    <select class="form-select" name="sort" onchange="events_filters()">
                                        <option value="publish-new">@lang('custom.newest')</option>
                                        <option value="publish-old">@lang('custom.oldest')</option>
                                        <option value="name-a">@lang('custom.name') (@lang('custom.a-z'))</option>
                                        <option value="name-z">@lang('custom.name') (@lang('custom.z-a'))</option>
                                        <option value="attend-highest">@lang('custom.attend') (@lang('custom.highest'))</option>
                                        <option value="attend-lowest">@lang('custom.attend') (@lang('custom.lowest'))</option>
                                    </select>
                                </div>
                                <div class="limit d-flex align-items-center">
                                    <p class="mb-0 me-1 fw-bold">@lang('custom.show')</p>
                                    <select class="form-select" name="limit" onchange="events_filters()">
                                        <option value="13" {{ request()->limit == 13 ? 'selected' : '' }}>13</option>
                                        <option value="25" {{ request()->limit == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request()->limit == 50 ? 'selected' : '' }}>50</option>
                                        <option value="70" {{ request()->limit == 70 ? 'selected' : '' }}>70</option>
                                        <option value="100" {{ request()->limit == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="events-container w-100">
                @include('front.parts.events-list')
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
    <script src="{{ asset('front/js/events.js') }}"></script>
@endsection