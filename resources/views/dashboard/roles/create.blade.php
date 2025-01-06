@extends('dashboard.layouts.app')

@section('title', __('dashboard.roles.create'))

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-sm-auto ms-auto">
                <a href="{{ route('dashboard.roles.index') }}"><button class="btn btn-light"><i class="ri-arrow-go-forward-fill me-1 align-bottom"></i> @lang('dashboard.return')</button></a>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
</div>
<form id="create-role-form">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="name">@lang('dashboard.role.name')</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="@lang('dashboard.enter') @lang('dashboard.name')">
                    </div>
                </div>
            </div>
            <!-- end card -->

            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('dashboard.page')</th>
                                <th>@lang('dashboard.roles')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>@lang('dashboard.website-settings')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::website_settings_show->value }}" value="{{ \App\PermissionsType::website_settings_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::website_settings_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::website_settings_edit->value }}" value="{{ \App\PermissionsType::website_settings_edit->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::website_settings_edit->value }}">
                                            @lang('dashboard.edit')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.people')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::people_show->value }}" value="{{ \App\PermissionsType::people_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::people_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::people_edit->value }}" value="{{ \App\PermissionsType::people_edit->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::people_edit->value }}">
                                            @lang('dashboard.edit')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::people_delete->value }}" value="{{ \App\PermissionsType::people_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::people_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::people_create->value }}" value="{{ \App\PermissionsType::people_create->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::people_create->value }}">
                                            @lang('dashboard.create')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.contact')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::contacts_show->value }}" value="{{ \App\PermissionsType::contacts_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::contacts_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::contacts_delete->value }}" value="{{ \App\PermissionsType::contacts_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::contacts_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.events')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::events_show->value }}" value="{{ \App\PermissionsType::events_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::events_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::events_edit->value }}" value="{{ \App\PermissionsType::events_edit->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::events_edit->value }}">
                                            @lang('dashboard.edit')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::events_delete->value }}" value="{{ \App\PermissionsType::events_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::events_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::events_create->value }}" value="{{ \App\PermissionsType::events_create->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::events_create->value }}">
                                            @lang('dashboard.create')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.events_reviews')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::events_reviews_show->value }}" value="{{ \App\PermissionsType::events_reviews_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::events_reviews_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::events_reviews_delete->value }}" value="{{ \App\PermissionsType::events_reviews_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::events_reviews_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.quote')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::quote_show->value }}" value="{{ \App\PermissionsType::quote_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::quote_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::quote_edit->value }}" value="{{ \App\PermissionsType::quote_edit->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::quote_edit->value }}">
                                            @lang('dashboard.edit')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::quote_delete->value }}" value="{{ \App\PermissionsType::quote_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::quote_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::quote_create->value }}" value="{{ \App\PermissionsType::quote_create->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::quote_create->value }}">
                                            @lang('dashboard.create')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.blogs')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::blogs_show->value }}" value="{{ \App\PermissionsType::blogs_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::blogs_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::blogs_delete->value }}" value="{{ \App\PermissionsType::blogs_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::blogs_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::blogs_approve->value }}" value="{{ \App\PermissionsType::blogs_approve->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::blogs_approve->value }}">
                                            @lang('dashboard.approve')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.blogs_likes')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::blogs_likes_show->value }}" value="{{ \App\PermissionsType::blogs_likes_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::blogs_likes_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::blogs_likes_delete->value }}" value="{{ \App\PermissionsType::blogs_likes_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::blogs_likes_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.blogs_comments')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::blogs_comments_show->value }}" value="{{ \App\PermissionsType::blogs_comments_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::blogs_comments_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::blogs_comments_delete->value }}" value="{{ \App\PermissionsType::blogs_comments_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::blogs_comments_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.articles_categories')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::articles_categories_show->value }}" value="{{ \App\PermissionsType::articles_categories_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::articles_categories_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::articles_categories_edit->value }}" value="{{ \App\PermissionsType::articles_categories_edit->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::articles_categories_edit->value }}">
                                            @lang('dashboard.edit')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::articles_categories_delete->value }}" value="{{ \App\PermissionsType::articles_categories_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::articles_categories_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::articles_categories_create->value }}" value="{{ \App\PermissionsType::articles_categories_create->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::articles_categories_create->value }}">
                                            @lang('dashboard.create')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.articles')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::articles_show->value }}" value="{{ \App\PermissionsType::articles_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::articles_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::articles_edit->value }}" value="{{ \App\PermissionsType::articles_edit->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::articles_edit->value }}">
                                            @lang('dashboard.edit')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::articles_delete->value }}" value="{{ \App\PermissionsType::articles_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::articles_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::articles_create->value }}" value="{{ \App\PermissionsType::articles_create->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::articles_create->value }}">
                                            @lang('dashboard.create')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.articles_likes')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::articles_likes_show->value }}" value="{{ \App\PermissionsType::articles_likes_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::articles_likes_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::articles_likes_delete->value }}" value="{{ \App\PermissionsType::articles_likes_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::articles_likes_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.articles_comments')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::articles_comments_show->value }}" value="{{ \App\PermissionsType::articles_comments_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::articles_comments_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::articles_comments_delete->value }}" value="{{ \App\PermissionsType::articles_comments_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::articles_comments_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.books_categories')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::books_categories_show->value }}" value="{{ \App\PermissionsType::books_categories_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::books_categories_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::books_categories_edit->value }}" value="{{ \App\PermissionsType::books_categories_edit->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::books_categories_edit->value }}">
                                            @lang('dashboard.edit')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::books_categories_delete->value }}" value="{{ \App\PermissionsType::books_categories_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::books_categories_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::books_categories_create->value }}" value="{{ \App\PermissionsType::books_categories_create->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::books_categories_create->value }}">
                                            @lang('dashboard.create')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.books')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::books_show->value }}" value="{{ \App\PermissionsType::books_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::books_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::books_edit->value }}" value="{{ \App\PermissionsType::books_edit->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::books_edit->value }}">
                                            @lang('dashboard.edit')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::books_delete->value }}" value="{{ \App\PermissionsType::books_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::books_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::books_create->value }}" value="{{ \App\PermissionsType::books_create->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::books_create->value }}">
                                            @lang('dashboard.create')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.books_requests')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::books_requests_show->value }}" value="{{ \App\PermissionsType::books_requests_show->value }}" >
                                        <label class="form-check-label" for="{{ \App\PermissionsType::books_requests_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::books_requests_delete->value }}" value="{{ \App\PermissionsType::books_requests_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::books_requests_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::books_requests_action->value }}" value="{{ \App\PermissionsType::books_requests_action->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::books_requests_action->value }}">
                                            @lang('dashboard.action')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.books_reviews')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::books_reviews_show->value }}" value="{{ \App\PermissionsType::books_reviews_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::books_reviews_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::books_reviews_delete->value }}" value="{{ \App\PermissionsType::books_reviews_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::books_reviews_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.users')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::users_show->value }}" value="{{ \App\PermissionsType::users_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::users_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::users_edit->value }}" value="{{ \App\PermissionsType::users_edit->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::users_edit->value }}">
                                            @lang('dashboard.edit')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::users_delete->value }}" value="{{ \App\PermissionsType::users_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::users_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::users_create->value }}" value="{{ \App\PermissionsType::users_create->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::users_create->value }}">
                                            @lang('dashboard.create')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.roles')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::roles_show->value }}" value="{{ \App\PermissionsType::roles_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::roles_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::roles_edit->value }}" value="{{ \App\PermissionsType::roles_edit->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::roles_edit->value }}">
                                            @lang('dashboard.edit')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::roles_delete->value }}" value="{{ \App\PermissionsType::roles_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::roles_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::roles_create->value }}" value="{{ \App\PermissionsType::roles_create->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::roles_create->value }}">
                                            @lang('dashboard.create')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('dashboard.api.posts')</td>
                                <td>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::posts_api_show->value }}" value="{{ \App\PermissionsType::posts_api_show->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::posts_api_show->value }}">
                                            @lang('dashboard.show')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::posts_api_delete->value }}" value="{{ \App\PermissionsType::posts_api_delete->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::posts_api_delete->value }}">
                                            @lang('dashboard.delete')
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input name="permission[]" class="form-check-input" type="checkbox" id="{{ \App\PermissionsType::posts_api_approve->value }}" value="{{ \App\PermissionsType::posts_api_approve->value }}">
                                        <label class="form-check-label" for="{{ \App\PermissionsType::posts_api_approve->value }}">
                                            @lang('dashboard.approve')
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <div class="row">
        <div class="text-end mb-3">
            <button type="submit" class="btn btn-success w-sm">@lang('dashboard.create')</button>
        </div>
    </div>
</form>

@endsection

@section('custom-js')
    <script src="{{ asset('back/js/roles.js') }}"></script>
@endsection