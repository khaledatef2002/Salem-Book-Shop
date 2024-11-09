@extends('dashboard.layouts.app')

@section('title', __('dashboard.quote.edit'))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-sm-auto ms-auto">
                <a href="{{ route('dashboard.quote.index') }}"><button class="btn btn-light"><i class="ri-arrow-go-forward-fill me-1 align-bottom"></i> @lang('dashboard.return')</button></a>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
</div>
<form id="edit-quote-form" data-id="{{ $quote->id }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="author_id">@lang('dashboard.author')</label>
                        <select class="form-control" id="author_id" name="author_id">
                            <option></option>
                        </select>
                    </div>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                        <div class="mb-3">
                            <label class="form-label" for="{{ $locale['locale'] }}.title">@lang('dashboard.'. $locale['locale'] .'.quote')</label>
                            <textarea class="form-control" id="{{ $locale['locale'] }}.title" name="title[{{ $locale['locale'] }}]" placeholder="@lang('dashboard.enter') @lang('dashboard.title')">{{ $quote->getTranslation('title', $locale['locale']) }}</textarea>
                        </div>
                    @endforeach
                    <div class="text-end mb-1">
                        <button type="submit" class="btn btn-success w-sm">@lang('custom.save')</button>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
</form>

@endsection

@section('custom-js')
<script src="{{ asset('back/js/quotes.js') }}"></script>
<script>
$(document).ready(function() {
    $('select').select2({
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
                            text: author.name.{{ LaravelLocalization::getCurrentLocale() }}
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 0 // Require at least 1 character to start searching
    });

    var option = new Option("{{ $quote->author->name }}", {{ $quote->author_id }}, true, true);
    $('select').append(option).trigger('change'); // Append and select the option
});
</script>

@endsection