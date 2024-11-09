@extends('dashboard.layouts.app')

@section('title', __('dashboard.book.create'))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-sm-auto ms-auto">
                <a href="{{ route('dashboard.books.index') }}"><button class="btn btn-light"><i class="ri-arrow-go-forward-fill me-1 align-bottom"></i> @lang('dashboard.return')</button></a>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
</div>
<form id="create-book-form">
    @csrf
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                        <div class="mb-3">
                            <label class="form-label" for="{{ $locale['locale'] }}.title">@lang('dashboard.'. $locale['locale'] .'.book.title')</label>
                            <input type="text" class="form-control" id="{{ $locale['locale'] }}.title" name="title[{{ $locale['locale'] }}]" placeholder="@lang('dashboard.enter') @lang('dashboard.title')">
                        </div>
                    @endforeach
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                        <div class="mb-3">
                            <label class="form-label" for="{{ $locale['locale'] }}.description">@lang('dashboard.'. $locale['locale'] .'.book.description')</label>
                            <textarea class="form-control" id="{{ $locale['locale'] }}.description" name="description[{{ $locale['locale'] }}]" placeholder="@lang('dashboard.enter') @lang('dashboard.description')"></textarea>
                        </div>
                    @endforeach
                    <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                        <input type="checkbox" class="form-check-input" id="downloadable" name="downloadable">
                        <label class="form-check-label" for="downloadable">Downloadable</label>
                    </div>
                </div>
            </div>
            <!-- end card -->
            <div class="card">
                <div class="card-body">
                    <div class="dropzone">
                        <div class="fallback">
                            <input name="file" type="file" multiple="multiple">
                        </div>
                        <div class="dz-message needsclick">
                            <div class="mb-3">
                                <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                            </div>

                            <h4>Drop files here or click to upload.</h4>
                        </div>
                    </div>

                    <ul class="list-unstyled mb-0" id="dropzone-preview">
                        <li class="mt-2" id="dropzone-preview-list">
                            <!-- This is used as the file preview template -->
                            <div class="border rounded">
                                <div class="d-flex p-2">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm bg-light rounded">
                                            <img data-dz-thumbnail class="img-fluid rounded d-block" src="assets/images/new-document.png" alt="Dropzone-Image" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="pt-1">
                                            <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                            <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                            <strong class="error text-danger" data-dz-errormessage></strong>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>                                      
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Book Source</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="source" class="form-label">Default file input example</label>
                        <input class="form-control" type="file" id="source" name="source" accept=".pdf">
                    </div>
                </div>
            </div>
            <!-- end card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Select Author</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="author_id">@lang('dashboard.author')</label>
                        <select class="form-control" id="author_id" name="author_id">
                            <option></option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- end card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Select Category</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="category_id">@lang('dashboard.category')</label>
                        <select class="form-control" id="category_id" name="category_id">
                            <option></option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- end card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Enter Keywords</h5>
                </div>
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="keywords" class="form-label">@lang('dashboard.website-settings.keywords')</label>
                            <input class="form-control" placeholder="@lang('dashboard.enter') @lang('dashboard.website-settings.keywords')" id="keywords" name="keywords" data-choices data-choices-text-unique-true data-choices-removeItem type="text" />
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
    <script src="{{ asset('back/js/books.js') }}"></script>
    <script>
        var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
        dropzonePreviewNode.id = "";
        var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
        dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
        let uploaded_temp = []
        var dropzone = new Dropzone(".dropzone", {
            url: '{{ route("dashboard.book.upload") }}',
            method: "post",
            previewTemplate: previewTemplate,
            previewsContainer: "#dropzone-preview",
            parallelUploads: 1,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF Token for Laravel
            },
            init: function() {
                this.on("success", function(file, response) {
                    uploaded_temp.push(response.path)
                });
            }
        });
        
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
                                    text: author.name.{{ LaravelLocalization::getCurrentLocale() }}
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0 // Require at least 1 character to start searching
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
                                    text: category.name.{{ LaravelLocalization::getCurrentLocale() }}
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