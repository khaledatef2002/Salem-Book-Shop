@extends('dashboard.layouts.app')

@section('title', __('dashboard.conacts'))

@section('content')

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped" id="dataTables">
            <thead>
                <tr class="table-dark">
                    <th>@lang('dashboard.id')</th>
                    <th>@lang('dashboard.user')</th>
                    <th>@lang('dashboard.email')</th>
                    <th>@lang('dashboard.phone')</th>
                    <th>@lang('dashboard.message')</th>
                    <th>@lang('dashboard.action')</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal" id="contactMessage" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">@lang('dashboard.contacts.message')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="d-flex flex-column align-items-center gap-1">
                <img src="" width="40" height="40" class="rounded-5">
                <span></span>
            </div>
            <p class="message"></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('custom.close')</button>
        </div>
      </div>
    </div>
</div>
@endsection

@section('custom-js')
    <script src="{{ asset('back/js/contacts.js') }}"></script>
    <script>
        var table
        $(document).ready( function () {
            table = $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.contacts.index') }}",
                columns: [
                            { data: 'id', name: 'id' },
                            { data: 'user', name: 'user' },
                            { data: 'email', name: 'email' },
                            { data: 'phone', name: 'phone' },
                            { data: 'message', name: 'message' },
                            { data: 'action', name: 'action'}
                        ]
            });
        });
    </script>
@endsection