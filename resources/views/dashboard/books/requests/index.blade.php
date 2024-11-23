@extends('dashboard.layouts.app')

@section('title', __('dashboard.books'))

@section('content')

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped" id="dataTables">
            <thead>
                <tr class="table-dark">
                    <th>#</th>
                    <th>@lang('dashboard.book')</th>
                    <th>@lang('dashboard.user')</th>
                    <th>@lang('dashboard.state')</th>
                    <th>@lang('dashboard.action')</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('custom-js')
    <script src="{{ asset('back/js/books-requests.js') }}"></script>
    <script>
        var table
        $(document).ready( function () {
            table = $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.books-requests.index') }}",
                columns: [
                            { data: 'DT_RowIndex', name: 'DT_RowIndex', title: '#'  },
                            { data: 'book', name: 'book' },
                            { data: 'user', name: 'user' },
                            { data: 'state', name: 'state' },
                            { data: 'action', name: 'action'}
                        ]
            });
        });
    </script>
@endsection