@extends('dashboard.layouts.app')

@section('title', __('dashboard.articles.comments'))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-sm-auto ms-auto">
                <a href="{{ route('dashboard.articles.index') }}"><button class="btn btn-light"><i class="ri-arrow-go-forward-fill me-1 align-bottom"></i> @lang('dashboard.return.all-articles')</button></a>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped" id="dataTables">
            <thead>
                <tr class="table-dark">
                    <th>@lang('dashboard.id')</th>
                    <th>@lang('dashboard.article')</th>
                    <th>@lang('dashboard.user')</th>
                    <th>@lang('dashboard.comment')</th>
                    <th>@lang('dashboard.action')</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('custom-js')
    <script src="{{ asset('back/js/articles-comments.js') }}"></script>
    <script>
        var table
        $(document).ready( function () {
            table = $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.article-comments.index') }}",
                columns: [
                            { data: 'id', name: 'id' },
                            { data: 'article', name: 'article' },
                            { data: 'user', name: 'user' },
                            { data: 'comment', name: 'comment' },
                            { data: 'action', name: 'action'}
                        ]
            });
        });
    </script>
@endsection