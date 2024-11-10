@extends('dashboard.layouts.app')

@section('title', __('dashboard.event.create'))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-sm-auto ms-auto">
                <a href="{{ route('dashboard.events.index') }}"><button class="btn btn-light"><i class="ri-arrow-go-forward-fill me-1 align-bottom"></i> @lang('dashboard.return')</button></a>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
</div>
<form id="create-event-form">
    @csrf
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                        <div class="mb-3">
                            <label class="form-label" for="{{ $locale['locale'] }}.title">@lang('dashboard.'. $locale['locale'] .'.event.title')</label>
                            <input type="text" class="form-control" id="{{ $locale['locale'] }}.title" name="title[{{ $locale['locale'] }}]" placeholder="@lang('dashboard.enter') @lang('dashboard.title')">
                        </div>
                    @endforeach
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                        <div class="mb-3">
                            <label class="form-label" for="{{ $locale['locale'] }}.description">@lang('dashboard.'. $locale['locale'] .'.event.description')</label>
                            <textarea class="form-control" id="{{ $locale['locale'] }}.description" name="description[{{ $locale['locale'] }}]" placeholder="@lang('dashboard.enter') @lang('dashboard.description')"></textarea>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Choose Cover</h5>
                    <p class="text-muted mb-0">Scale Ratio: (1: 0.6) (W:H)</p>
                </div>
                <div class="card-body">
                    <div class="auto-image-show">
                        <input id="cover" name="cover" type="file" class="profile-img-file-input" accept="image/*" hidden>
                        <label for="cover" class="profile-photo-edit d-flex justify-content-center align-items-center" style="width: 100%;aspect-ratio: 1 / 0.45;overflow:hidden">
                            <img src="" style="min-width:100%;min-height:100%;" alt="user-profile-image">
                        </label>
                    </div>                               
                </div>
            </div>
            <!-- end card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Select Instructor</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="instructor_id">@lang('dashboard.author')</label>
                        <select class="form-control" id="instructor_id" name="instructor_id[]" multiple="multiple">
                            <option></option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- end card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Enter Event Date</h5>
                </div>
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="date" class="form-label">@lang('dashboard.date')</label>
                            <input type="text" id="date" name="date" class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="Y/m/d" date-time-format="H:i" data-enable-time="" placeholder="Y/m/d H:i" readonly="readonly">
                        </div>
                    </div>
                </div>
            </div>
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
    <script src="{{ asset('back/js/events.js') }}"></script>
    <script>        
        $(document).ready(function() {
            $('select[name="instructor_id[]"]').select2({
                placeholder: "@lang('dashboard.select.choose-option')",
                ajax: {
                    url: '{{ route("dashboard.select2.instructors") }}', // Route to fetch users
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
                                    text: author.name.{{ LaravelLocalization::getCurrentLocale() }}
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0 // Require at least 1 character to start searching
            });
        });
        </script>
@endsection