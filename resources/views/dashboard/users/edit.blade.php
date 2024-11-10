@extends('dashboard.layouts.app')

@section('title', __('dashboard.user.edit'))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-sm-auto ms-auto">
                <a href="{{ route('dashboard.users.index') }}"><button class="btn btn-light"><i class="ri-arrow-go-forward-fill me-1 align-bottom"></i> @lang('dashboard.return')</button></a>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
</div>
<form id="edit-user-form" data-id="{{ $user->id }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <div class="mb-3 flex-fill">
                            <label class="form-label" for="first_name">@lang('custom.first-name')</label>
                            <input type="text" class="form-control" value="{{ $user->first_name }}" id="first_name" name="first_name" placeholder="@lang('custom.enter-first-name')">
                        </div>
                        <div class="mb-3 flex-fill">
                            <label class="form-label" for="last_name">@lang('custom.last-name')</label>
                            <input type="text" class="form-control" value="{{ $user->last_name }}" id="last_name" name="last_name" placeholder="@lang('custom.enter-last-name')">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">@lang('custom.email')</label>
                        <input type="text" class="form-control" value="{{ $user->email }}" id="email" name="email" placeholder="@lang('custom.email')">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">@lang('custom.new-password')</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="@lang('custom.password')">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">@lang('custom.phone')</label>
                        <div id="country-code-input" class="input-group mb-3" data-input-flag="">
                            <button class="btn btn-light border d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="country-flag country-flagimg rounded" height="20"></div>
                                <span class="ms-2 country-codeno">+{{ $user->country_code }}</span>
                            </button>
                            <input type="hidden" name="country_code" value="{{ $user->country_code }}">
                            <input type="text" name="phone" class="form-control rounded-end flag-input" value="{{ $user->phone }}" placeholder="Enter number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                            <div class="dropdown-menu w-100">
                                <div class="p-2 px-3 pt-1 searchlist-input">
                                    <input type="text" class="form-control form-control-sm border search-countryList" placeholder="Search country name or country code...">
                                </div>
                                <ul class="list-unstyled dropdown-menu-list mb-0">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                        <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" {{ $user->is_admin ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_admin">Is Admin</label>
                    </div>
                    <div class="mb-3" {{ $user->is_admin ? '' : 'style="display: none"' }}>
                        <label class="form-label" for="role">Role:</label>
                        <select class="form-control" id="role" name="role">
                            <option>@lang('dashboard.select.choose-option')</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->roles?->first()?->id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">User Image</h5>
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
                                        <img src="{{ $user->display_image }}" id="product-img" style="min-height: 100%;min-width: 100%;" />
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
            <button type="submit" class="btn btn-success w-sm">@lang('dashboard.save')</button>
        </div>
    </div>
</form>

@endsection

@section('additional-js-libs')
    <script src="{{ asset('front/libs/countries-data.js') }}"></script>
    <script src="{{ asset('front/libs/countries-flag.js') }}"></script>
@endsection

@section('custom-js')
    <script src="{{ asset('back/js/users.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('select[name="author_id"]').select2({
                placeholder: "@lang('dashboard.select.choose-option')",
                ajax: {
                    url: '{{ route("dashboard.select2.authors") }}', // Route to fetch users
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term // Search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function(author) {
                                return {
                                    id: author.id,
                                    text: author.name
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1 // Require at least 1 character to start searching
            });
            $('select[name="category_id"]').select2({
                placeholder: "@lang('dashboard.select.choose-option')",
                ajax: {
                    url: '{{ route("dashboard.select2.book_category") }}', // Route to fetch users
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term // Search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function(category) {
                                return {
                                    id: category.id,
                                    text: category.name
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1 // Require at least 1 character to start searching
            });
        });
        </script>
@endsection