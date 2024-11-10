@extends('dashboard.layouts.app')

@section('title', __('dashboard.event.edit'))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row g-2 d-flex align-items-center justify-content-between">
            <div class="col-sm-auto">
                {!! $event->date > now() ? "<span class='badge bg-info fs-6 py-2 px-3'>". __('dashboard.events.comming') ."</span>" : "<span class='badge bg-success fs-6 py-2 px-3'>". __('dashboard.events.finished') ."</span>" !!}
            </div>
            <div class="col-sm-auto">
                <a href="{{ route('dashboard.events.index') }}"><button class="btn btn-light"><i class="ri-arrow-go-forward-fill me-1 align-bottom"></i> @lang('dashboard.return')</button></a>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
</div>
<form id="edit-event-form" data-id="{{ $event->id }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                        <div class="mb-3">
                            <label class="form-label" for="{{ $locale['locale'] }}.title">@lang('dashboard.'. $locale['locale'] .'.event.title')</label>
                            <input type="text" class="form-control" id="{{ $locale['locale'] }}.title" name="title[{{ $locale['locale'] }}]" placeholder="@lang('dashboard.enter') @lang('dashboard.title')" value="{{ $event->getTranslation('title', $locale['locale']) }}">
                        </div>
                    @endforeach
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                        <div class="mb-3">
                            <label class="form-label" for="{{ $locale['locale'] }}.description">@lang('dashboard.'. $locale['locale'] .'.event.description')</label>
                            <textarea class="form-control" id="{{ $locale['locale'] }}.description" name="description[{{ $locale['locale'] }}]" placeholder="@lang('dashboard.enter') @lang('dashboard.description')">{{ $event->getTranslation('description', $locale['locale']) }}</textarea>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- end card -->
            @if ($event->date <= now())
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
            @endif
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
                            <img src="{{ asset('storage/' . $event->cover) }}" style="min-width:100%;min-height:100%;" alt="user-profile-image">
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
                            <input type="text" value="{{ $event->date }}" id="date" name="date" class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="Y/m/d" date-time-format="H:i" data-enable-time="" placeholder="Y/m/d H:i" readonly="readonly">
                        </div>
                    </div>
                </div>
            </div>
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

@section('custom-js')
    <script src="{{ asset('back/js/events.js') }}"></script>
    <script>       
        let deletedImages = [];
        let uploaded_temp = []
        @if ($event->date <= now())
            var dropzonePreviewNode = document.querySelector("#dropzone-preview-list");
            dropzonePreviewNode.id = "";
            var previewTemplate = dropzonePreviewNode.parentNode.innerHTML;
            dropzonePreviewNode.parentNode.removeChild(dropzonePreviewNode);
            var dropzone = new Dropzone(".dropzone", {
                url: '{{ route("dashboard.event.upload") }}',
                method: "post",
                previewTemplate: previewTemplate,
                previewsContainer: "#dropzone-preview",
                parallelUploads: 1,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF Token for Laravel
                },
                init: function() {
                    const existingImages = @json($data_images); // No need to parse again

                    // Loop through existing images and add them as previews
                    existingImages.forEach(image => {
                        let mockFile = { name: image.name, size: image.size, dataURL: image.url, id: image.id };

                        this.emit("addedfile", mockFile);     // Add file to Dropzone
                        this.emit("thumbnail", mockFile, image.url); // Show thumbnail
                        this.emit("complete", mockFile);      // Mark as complete
                        mockFile.previewElement.classList.add('dz-complete');

                        // Mark image as existing to prevent re-upload on submit
                        mockFile.existing = true;
                    });

                    // Event listener for file removal
                    this.on("removedfile", function(file) {
                        if (file.existing) {
                            deletedImages.push(file.id);
                        }
                    });
                    this.on("success", function(file, response) {
                        uploaded_temp.push(response.path)
                    });
                }
            }); 
        @endif
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
                                    text: author.name
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1 // Require at least 1 character to start searching
            });
        });
        let option;
        @foreach ($event->instructors as $instructor)
            option = new Option("{{ $instructor->name }}", {{ $instructor->id }}, true, true);
            $('select').append(option).trigger('change'); // Append and select the option

        @endforeach
        </script>
@endsection