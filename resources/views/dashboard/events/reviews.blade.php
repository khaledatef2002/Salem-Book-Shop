@extends('dashboard.layouts.app')

@section('title', __('dashboard.events.review') . " " . $event_title)

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row g-2 align-items-center">
            <div class="col-sm-auto">
                <i class="ri-calendar-event-line"></i> {{ $event_title }}
            </div>
            <div class="col-sm-auto ms-auto">
                <a href="{{ route('dashboard.events.index') }}"><button class="btn btn-light"><i class="ri-arrow-go-forward-fill me-1 align-bottom"></i> @lang('dashboard.return.all-events')</button></a>
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
                    <th>@lang('dashboard.event')</th>
                    <th>@lang('dashboard.user')</th>
                    <th>@lang('dashboard.stars')</th>
                    <th>@lang('dashboard.text')</th>
                    <th>@lang('dashboard.action')</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('custom-js')
    <script src="{{ asset('back/js/events-reviews.js') }}"></script>
    <script>
        var table
        $(document).ready( function () {
            table = $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.event.review.index', request()->event) }}",
                columns: [
                            { data: 'id', name: 'id' },
                            { data: 'event', name: 'event' },
                            { data: 'user', name: 'user' },
                            { data: 'stars', name: 'stars' },
                            { data: 'review_text', name: 'text' },
                            { data: 'action', name: 'action'}
                        ]
            });
        });
    </script>
@endsection