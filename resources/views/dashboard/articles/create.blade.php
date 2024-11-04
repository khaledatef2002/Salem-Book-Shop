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
<form id="create-article-form">
    @csrf
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter product title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="content">Content:</label>
                        <textarea class="form-control" id="content" name="content"></textarea>
                    </div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-lg-3">
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
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Choose Cover</h5>
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
    <script src="{{ asset('back/js/articles.js') }}"></script>
    <script>
        let images = [];
        let ckEditor;

        $(document).ready(function() {
            $('select[name="category_id"]').select2({
                placeholder: "@lang('dashboard.select.choose-option')",
                ajax: {
                    url: '{{ route("dashboard.select2.article_category") }}', // Route to fetch users
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

            ClassicEditor.create(document.querySelector('textarea[name="content"]'), {
                ckfinder: {
                    uploadUrl: '/dashboard/ckEditorUploadImage?command=QuickUpload&type=Images&responseType=json'
                }
            }).then(editor => {
                ckEditor = editor;
                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                    return {
                        upload: () => {
                            return loader.file
                                .then(file => new Promise((resolve, reject) => {
                                    const formData = new FormData();
                                    formData.append('upload', file);

                                    fetch('/dashboard/ckEditorUploadImage', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                        },
                                        body: formData
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        images.push(data.url)
                                        resolve({ default: data.url })
                                    })
                                    .catch(error => reject(error));
                                }));
                        }
                    };
                };
                editor.model.document.on('change:data', () => {
                    // Get current editor data (HTML content)
                    const editorData = editor.getData();
                    
                    // Check each URL in the images array to see if it still exists in the editor content
                    images = images.filter(imageUrl => {
                        if (!editorData.includes(imageUrl)) {
                            // If imageUrl is not found in the editor, send delete request to Laravel
                            fetch('/dashboard/ckEditorRemoveImage', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({ url: imageUrl })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log(`Image ${imageUrl} deleted from server`);
                                }
                            })
                            .catch(error => console.error('Error deleting image:', error));
                            
                            // Remove from images array
                            return false;
                        }
                        return true;
                    });
                });
            })
            .catch(error => {
                console.error(error);
            });
        });
        </script>
@endsection