@extends('dashboard.layouts.app')

@section('title', __('dashboard.events'))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-sm-auto ms-auto">
                <a href="{{ route('dashboard.events.create') }}"><button class="btn btn-success"><i class="ri-add-fill me-1 align-bottom"></i> @lang('dashboard.events.add')</button></a>
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
                    <th>@lang('dashboard.title')</th>
                    <th>@lang('dashboard.description')</th>
                    <th>@lang('dashboard.cover')</th>
                    <th>@lang('dashboard.status')</th>
                    <th>@lang('dashboard.reviews')</th>
                    <th>@lang('dashboard.date')</th>
                    <th>@lang('dashboard.action')</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('custom-js')
    <script src="{{ asset('back/js/events.js') }}"></script>
    <script>
        var table
        $(document).ready( function () {
            table = $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.events.index') }}",
                columns: [
                            { data: 'id', name: 'id' },
                            { data: 'title', name: 'title' },
                            { data: 'description', name: 'description' },
                            { data: 'cover', name: 'cover' },
                            { data: 'status', name: 'status' },
                            { data: 'reviews', name: 'reviews' },
                            { data: 'date', name: 'date' },
                            { data: 'action', name: 'action'}
                        ]
            });
        });
    </script>
@endsection