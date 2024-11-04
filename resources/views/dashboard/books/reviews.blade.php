@extends('dashboard.layouts.app')

@section('title', __('dashboard.books.review') . " " . $book_title)

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row g-2 align-items-center">
            <div class="col-sm-auto">
                <i class="ri-book-fill"></i> {{ $book_title }}
            </div>
            <div class="col-sm-auto ms-auto">
                <a href="{{ route('dashboard.books.index') }}"><button class="btn btn-light"><i class="ri-arrow-go-forward-fill me-1 align-bottom"></i> @lang('dashboard.return.all-books')</button></a>
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
                    <th>@lang('dashboard.book')</th>
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
    <script src="{{ asset('back/js/books-reviews.js') }}"></script>
    <script>
        var table
        $(document).ready( function () {
            table = $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.book-review.index', request()->book) }}",
                columns: [
                            { data: 'id', name: 'id' },
                            { data: 'book', name: 'book' },
                            { data: 'user', name: 'user' },
                            { data: 'stars', name: 'stars' },
                            { data: 'review_text', name: 'text' },
                            { data: 'action', name: 'action'}
                        ]
            });
        });
    </script>
@endsection