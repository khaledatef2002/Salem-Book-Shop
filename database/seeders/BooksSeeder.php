<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'aliquam quaerat voluptatem',
                'author_id' => 1,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since. Lorem Ipsum has been the industry’s standard dummy text ever since. Lorem Ipsum is simply dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since.',
                'category_id' => 1,
                'downloadable' => false,
                'source' => 'test'
            ]
        );
        Book::updateOrCreate(
            ['id' => 2],
            [
                'title' => 'aspetur autodit autfugit',
                'author_id' => 1,
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
                'category_id' => 2,
                'downloadable' => false,
                'source' => 'test'
            ]
        );
        Book::updateOrCreate(
            ['id' => 3],
            [
                'title' => 'magni dolores eosquies',
                'author_id' => 1,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since. Lorem Ipsum has been the industry’s standard dummy text ever since. Lorem Ipsum is simply dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since.',
                'category_id' => 3,
                'downloadable' => false,
                'source' => 'test'
            ]
        );
        Book::updateOrCreate(
            ['id' => 4],
            [
                'title' => 'perspiciatis unde omnis',
                'author_id' => 1,
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since. Lorem Ipsum has been the industry’s standard dummy text ever since. Lorem Ipsum is simply dummy text. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry’s standard dummy text ever since.',
                'category_id' => 4,
                'downloadable' => false,
                'source' => 'test'
            ]
        );
    }
}
