<?php

namespace App;

enum PermissionsType: string
{
    // website settings
    case website_settings_show = 'website_settings_show';
    case website_settings_edit = 'website_settings_edit';

    // people
    case people_show = 'people_show';
    case people_edit = 'people_edit';
    case people_delete = 'people_delete';
    case people_create = 'people_create';

    // contacts
    case contacts_show = 'contacts_show';
    case contacts_delete = 'contacts_delete';

    // events
    case events_show = 'events_show';
    case events_edit = 'events_edit';
    case events_delete = 'events_delete';
    case events_create = 'events_create';

    // events reviews
    case events_reviews_show = 'events_reviews_show';
    case events_reviews_delete = 'events_reviews_delete';

    // quote
    case quote_show = 'quote_show';
    case quote_edit = 'quote_edit';
    case quote_delete = 'quote_delete';
    case quote_create = 'quote_create';

    // blogs
    case blogs_show = 'blogs_show';
    case blogs_delete = 'blogs_delete';
    case blogs_create = 'blogs_create';
    case blogs_approve = 'blogs_approve';

    // blogs likes
    case blogs_likes_show = 'blogs_likes_show';
    case blogs_likes_delete = 'blogs_likes_delete';

    // blogs comments
    case blogs_comments_show = 'blogs_comments_show';
    case blogs_comments_delete = 'blogs_comments_delete';

    // articles categories
    case articles_categories_show = 'articles_categories_show';
    case articles_categories_edit = 'articles_categories_edit';
    case articles_categories_delete = 'articles_categories_delete';
    case articles_categories_create = 'articles_categories_create';

    // articles
    case articles_show = 'articles_show';
    case articles_edit = 'articles_edit';
    case articles_delete = 'articles_delete';
    case articles_create = 'articles_create';

    // articles likes
    case articles_likes_show = 'articles_likes_show';
    case articles_likes_delete = 'articles_likes_delete';

    // articles comments
    case articles_comments_show = 'articles_comments_show';
    case articles_comments_delete = 'articles_comments_delete';

    // books categories
    case books_categories_show = 'books_categories_show';
    case books_categories_edit = 'books_categories_edit';
    case books_categories_delete = 'books_categories_delete';
    case books_categories_create = 'books_categories_create';

    // books
    case books_show = 'books_show';
    case books_edit = 'books_edit';
    case books_delete = 'books_delete';
    case books_create = 'books_create';

    // books reviews
    case books_reviews_show = 'books_reviews_show';
    case books_reviews_delete = 'books_reviews_delete';

    // users reviews
    case users_show = 'users_show';
    case users_edit = 'users_edit';
    case users_delete = 'users_delete';
    case users_create = 'users_create';

    // roles reviews
    case roles_show = 'roles_show';
    case roles_edit = 'roles_edit';
    case roles_delete = 'roles_delete';
    case roles_create = 'roles_create';
}
