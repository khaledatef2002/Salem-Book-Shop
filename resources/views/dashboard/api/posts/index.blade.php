@extends('dashboard.layouts.app')

@section('title', __('dashboard.blogs'))

@section('content')

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped" id="dataTables">
            <thead>
                <tr class="table-dark">
                    <th>@lang('dashboard.id')</th>
                    <th>@lang('dashboard.title')</th>
                    <th>@lang('dashboard.content')</th>
                    <th>@lang('dashboard.category')</th>
                    <th>@lang('dashboard.image')</th>
                    <th>@lang('dashboard.source')</th>
                    <th>@lang('dashboard.date')</th>
                    <th>@lang('dashboard.action')</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

<!-- Modal -->
<div class="modal fade" id="approvePost" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('dashboard.api.post.approve')</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" for="category_id">@lang('dashboard.category')</label>
                    <select class="form-control" id="category_id" name="category_id">
                        <option></option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('dashboard.close')</button>
                <button type="button" class="btn btn-primary approve-button">@lang('dashboard.approve')</button>
            </div>
        </div>
    </div>
</div>

@section('custom-js')
    <script src="{{ asset('back/js/ApiPost.js') }}"></script>
    <script>
        var table
        $(document).ready( function () {
            table = $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.api.posts.index') }}",
                columns: [
                            { data: 'id', name: 'id' },
                            { data: 'title', name: 'title' },
                            { data: 'content', name: 'content' },
                            { data: 'category', name: 'category' },
                            { data: 'imageUrl', name: 'image' },
                            { data: 'source', name: 'source' },
                            { data: 'created_at', name: 'date' },
                            { data: 'action', name: 'action'}
                        ]
            });
            $('select[name="category_id"]').select2({
                placeholder: "@lang('dashboard.select.choose-category')",
                dropdownParent: $("#approvePost"),
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
        });
    </script>
@endsection