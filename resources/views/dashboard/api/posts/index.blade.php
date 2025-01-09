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