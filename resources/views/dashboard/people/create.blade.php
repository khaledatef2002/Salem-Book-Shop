@extends('dashboard.layouts.app')

@section('title', __('dashboard.people.create'))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-sm-auto ms-auto">
                <a href="{{ route('dashboard.people.index') }}"><button class="btn btn-light"><i class="ri-arrow-go-forward-fill me-1 align-bottom"></i> @lang('dashboard.return')</button></a>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
</div>
<form id="create-person-form">
    @csrf
    <div class="row">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                        <div class="mb-3">
                            <label class="form-label" for="{{ $locale['locale'] }}.name">@lang('dashboard.'. $locale['locale'] .'.person.name')</label>
                            <input type="text" class="form-control" id="{{ $locale['locale'] }}.name" name="name[{{ $locale['locale'] }}]" placeholder="@lang('dashboard.enter') @lang('dashboard.name')">
                        </div>
                    @endforeach
                    <div class="mb-3">
                        <label class="form-label" for="type">Person Type:</label>
                        <select class="form-control" id="type" name="type">
                            <option value="" disabled selected>-- @lang('dashboard.select.choose-option') --</option>
                            @foreach ($PeopleType as $key => $type)
                                <option value="{{ $type }}">@lang('dashboard.' . $key)</option>
                            @endforeach
                        </select>
                    </div>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                        <div class="mb-3">
                            <label class="form-label" for="{{ $locale['locale'] }}.about">@lang('dashboard.'. $locale['locale'] .'.people.about')</label>
                            <textarea class="form-control" id="{{ $locale['locale'] }}.about" name="about[{{ $locale['locale'] }}]" placeholder="@lang('dashboard.enter') @lang('dashboard.about')"></textarea>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-lg-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Person Image</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="text-center">
                            <div class="position-relative d-inline-block auto-image-show">
                                <div class="position-absolute top-100 start-100 translate-middle">
                                    <label for="image" class="mb-0" data-bs-toggle="tooltip" data-bs-placement="right" title="Select Image">
                                        <div class="avatar-xs">
                                            <div class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                <i class="ri-image-fill"></i>
                                            </div>
                                        </div>
                                    </label>
                                    <input class="form-control d-none" name="image" id="image" type="file" accept="image/png, image/gif, image/jpeg">
                                </div>
                                <div class="avatar-lg">
                                    <div class="avatar-title bg-light rounded">
                                        <img src="" id="product-img" style="min-height: 100%;min-width: 100%;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end card -->

        </div>
        <!-- end col -->
    </div>
    <div class="row">
        <div class="text-end mb-3">
            <button type="submit" class="btn btn-success w-sm">@lang('dashboard.create')</button>
        </div>
    </div>
</form>

@endsection

@section('custom-js')
    <script src="{{ asset('back/js/people.js') }}"></script>
@endsection