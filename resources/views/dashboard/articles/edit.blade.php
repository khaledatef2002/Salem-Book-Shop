@extends('dashboard.layouts.app')

@section('title', __('dashboard.articles.create'))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-sm-auto ms-auto">
                <a href="{{ route('dashboard.articles.index') }}"><button class="btn btn-light"><i class="ri-arrow-go-forward-fill me-1 align-bottom"></i> @lang('dashboard.return')</button></a>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
</div>
<form id="edit-article-form" data-id="{{ $article->id }}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                        <div class="mb-3">
                            <label class="form-label" for="{{ $locale['locale'] }}.title">@lang('dashboard.'. $locale['locale'] .'.article.title')</label>
                            <input value="{{ $article->getTranslation('title', $locale['locale']) }}" type="text" class="form-control" id="{{ $locale['locale'] }}.title" name="title[{{ $locale['locale'] }}]" placeholder="@lang('dashboard.enter') @lang('dashboard.title')">
                        </div>
                    @endforeach
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                        <div class="mb-3">
                            <label class="form-label" for="{{ $locale['locale'] }}.content">@lang('dashboard.'. $locale['locale'] .'.article.content')</label>
                            <textarea class="form-control" id="{{ $locale['locale'] }}.content" name="content[{{ $locale['locale'] }}]" placeholder="@lang('dashboard.enter') @lang('dashboard.content')">{{ $article->getTranslation('content', $locale['locale']) }}</textarea>
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
                            <input class="form-control" placeholder="@lang('dashboard.enter') @lang('dashboard.website-settings.keywords')" id="keywords" name="keywords" data-choices data-choices-text-unique-true data-choices-removeItem type="text" value="{{ $article->keywords }}" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Choose Cover</h5>
                    <p class="text-muted mb-0">Scale Ratio: (1: 0.45) (W:H)</p>
                </div>
                <div class="card-body">
                    <div class="auto-image-show">
                        <input id="cover" name="cover" type="file" class="profile-img-file-input" accept="image/*" hidden>
                        <label for="cover" class="profile-photo-edit d-flex justify-content-center align-items-center" style="width: 100%;aspect-ratio: 1 / 0.45;overflow:hidden">
                            <img src="{{ asset('storage/' . $article->cover) }}" style="min-width:100%;min-height:100%;" alt="user-profile-image">
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
            <button type="submit" class="btn btn-success w-sm">@lang('dashboard.save')</button>
        </div>
    </div>
</form>

@endsection

@section('custom-js')
    <script src="{{ asset('back/js/articles.js') }}"></script>
    <script>
        let images = [];
        @foreach (LaravelLocalization::getSupportedLocales() as $locale)
            let images{{ $locale['locale'] }} = [];
        @endforeach

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
                                    text: category.name.{{ LaravelLocalization::getCurrentLocale() }}
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 0 // Require at least 1 character to start searching
            });

            @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                let ckEditor{{ $locale['locale'] }};

                ClassicEditor.create(document.querySelector('textarea[name="content[{{ $locale['locale'] }}]"]'), {
                    ckfinder: {
                        uploadUrl: '/dashboard/ckEditorUploadImage?command=QuickUpload&type=Images&responseType=json'
                    },
                    mediaEmbed: {
                        previewsInData: true,
                        providers: [
                            {
                                name: 'youtube',
                                url: [
                                    /^youtube\.com\/watch\?v=([\w-]+)/,
                                    /^youtu\.be\/([\w-]+)/
                                ],
                                html: match => (
                                    `<div style="position: relative; padding-bottom: 56.25%; height: 0;">
                                        <iframe src="https://www.youtube.com/embed/${match[1]}" alt="khaled"
                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" 
                                                frameborder="0" allowfullscreen></iframe>
                                    </div>`
                                )
                            }
                        ]
                    }
                }).then(editor => {
                    ckEditor{{ $locale['locale'] }} = editor;
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
                        
                        $("textarea[name='content[{{ $locale['locale'] }}]']").val(editor.getData())

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
                        images = [
                            @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                                ...images{{ $locale['locale'] }},
                            @endforeach
                        ]
                    });
                })
                .catch(error => {
                    console.error(error);
                });
            @endforeach
        });

        var option = new Option("{{ $article->category->name }}", {{ $article->category_id }}, true, true);
        $('select').append(option).trigger('change'); // Append and select the option
        </script>
@endsection