@extends('dashboard.layouts.app')

@section('title', __('dashboard.blogs'))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-sm-auto ms-auto">
                <a href="{{ route('dashboard.blogs.create') }}"><button class="btn btn-success"><i class="ri-add-fill me-1 align-bottom"></i> @lang('dashboard.blogs.add')</button></a>
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
                    <th>@lang('dashboard.user')</th>
                    <th>@lang('dashboard.content')</th>
                    <th>@lang('dashboard.action')</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('custom-js')
    <script src="{{ asset('back/js/blogs.js') }}"></script>
    <script>
        var table
        $(document).ready( function () {
            table = $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.blogs.index') }}",
                columns: [
                            { data: 'id', name: 'id' },
                            { data: 'user', name: 'user' },
                            { data: 'content', name: 'content' },
                            { data: 'action', name: 'action'}
                        ]
            });
        });
    </script>
@endsection