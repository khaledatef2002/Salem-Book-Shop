@extends('dashboard.layouts.app')

@section('title', __('dashboard.articles'))

@section('content')

@if (Auth::user()->hasPermissionTo('articles_create'))
    <div class="card">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-sm-auto ms-auto">
                    <a href="{{ route('dashboard.articles.create') }}"><button class="btn btn-success"><i class="ri-add-fill me-1 align-bottom"></i> @lang('dashboard.articles.add')</button></a>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
    </div>
@endif
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped" id="dataTables">
            <thead>
                <tr class="table-dark">
                    <th>@lang('dashboard.id')</th>
                    <th>@lang('dashboard.title')</th>
                    <th>@lang('dashboard.user')</th>
                    <th>@lang('dashboard.content')</th>
                    <th>@lang('dashboard.cover')</th>
                    <th>@lang('dashboard.likes')</th>
                    <th>@lang('dashboard.comments')</th>
                    <th>@lang('dashboard.action')</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('custom-js')
    <script src="{{ asset('back/js/articles.js') }}"></script>
    <script>
        var table
        $(document).ready( function () {
            table = $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.articles.index') }}",
                columns: [
                            { data: 'id', name: 'id' },
                            { data: 'title', name: 'title' },
                            { data: 'user', name: 'user' },
                            { data: 'content', name: 'content' },
                            { data: 'cover', name: 'cover' },
                            { data: 'likes', name: 'likes' },
                            { data: 'comments', name: 'comments' },
                            { data: 'action', name: 'action'}
                        ]
            });
        });
    </script>
@endsection