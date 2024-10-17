<?php

namespace Database\Seeders;

use App\Models\BookImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookImage::updateOrCreate(
            ['id' => 1],
            [
                'url' => 'uploads/books/1.jpg',
                'book_id' => 1,
            ]
        );
        BookImage::updateOrCreate(
            ['id' => 2],
            [
                'url' => 'uploads/books/2.jpg',
                'book_id' => 1,
            ]
        );
        BookImage::updateOrCreate(
            ['id' => 3],
            [
                'url' => 'uploads/books/3.jpg',
                'book_id' => 1,
            ]
        );
        BookImage::updateOrCreate(
            ['id' => 4],
            [
                'url' => 'uploads/books/4.jpg',
                'book_id' => 2,
            ]
        );
        BookImage::updateOrCreate(
            ['id' => 5],
            [
                'url' => 'uploads/books/5.jpg',
                'book_id' => 2,
            ]
        );
        BookImage::updateOrCreate(
            ['id' => 6],
            [
                'url' => 'uploads/books/6.jpg',
                'book_id' => 2,
            ]
        );
        BookImage::updateOrCreate(
            ['id' => 7],
            [
                'url' => 'uploads/books/7.jpg',
                'book_id' => 3,
            ]
        );
        BookImage::updateOrCreate(
            ['id' => 8],
            [
                'url' => 'uploads/books/8.jpg',
                'book_id' => 3,
            ]
        );
        BookImage::updateOrCreate(
            ['id' => 9],
            [
                'url' => 'uploads/books/9.jpg',
                'book_id' => 3,
            ]
        );
        BookImage::updateOrCreate(
            ['id' => 10],
            [
                'url' => 'uploads/books/10.jpg',
                'book_id' => 4,
            ]
        );
        BookImage::updateOrCreate(
            ['id' => 11],
            [
                'url' => 'uploads/books/11.jpg',
                'book_id' => 4,
            ]
        );
        BookImage::updateOrCreate(
            ['id' => 12],
            [
                'url' => 'uploads/books/12.jpg',
                'book_id' => 4,
            ]
        );
    }
}
