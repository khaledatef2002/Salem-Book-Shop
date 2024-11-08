@extends('dashboard.layouts.app')

@section('title', __('dashboard.articles.categories'))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-sm-auto ms-auto">
                <a data-bs-toggle="modal" data-bs-target="#addArticleCategoryModal"><button class="btn btn-success"><i class="ri-add-fill me-1 align-bottom"></i> @lang('dashboard.books.categories.add')</button></a>
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
                    <th>@lang('dashboard.name')</th>
                    <th>@lang('dashboard.action')</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal" id="addArticleCategoryModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">@lang('dashboard.articles.categories.add')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="add-article-category-form">
            @csrf
            <div class="modal-body">
                @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                    <div class="mb-3">
                        <label class="form-label" for="{{ $locale['locale'] }}.name">@lang('dashboard.'. $locale['locale'] .'.name')</label>
                        <input type="text" class="form-control" id="{{ $locale['locale'] }}.name" name="name[{{ $locale['locale'] }}]" placeholder="@lang('dashboard.enter') @lang('dashboard.name')">
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('custom.close')</button>
              <button type="submit" class="btn btn-primary">@lang('dashboard.add')</button>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal" id="editArticleCategoryModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">@lang('dashboard.articles.categories.edit')</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="edit-article-category-form">
            @csrf
            @method('PUT')
            <div class="modal-body">
                @foreach (LaravelLocalization::getSupportedLocales() as $locale)
                    <div class="mb-3">
                        <label class="form-label" for="{{ $locale['locale'] }}.name">@lang('dashboard.'. $locale['locale'] .'.name')</label>
                        <input type="text" class="form-control" id="{{ $locale['locale'] }}.name" name="name[{{ $locale['locale'] }}]" placeholder="@lang('dashboard.enter') @lang('dashboard.name')">
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">@lang('custom.close')</button>
              <button type="submit" class="btn btn-primary">@lang('dashboard.edit')</button>
            </div>
        </form>
      </div>
    </div>
</div>
@endsection

@section('custom-js')
    <script src="{{ asset('back/js/articles-categories.js') }}"></script>
    <script>
        var table
        $(document).ready( function () {
            table = $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.articles-category.index') }}",
                columns: [
                            { data: 'id', name: 'id' },
                            { data: 'name', name: 'name' },
                            { data: 'action', name: 'action'}
                        ]
            });
        });
    </script>
@endsection