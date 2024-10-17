<?php

namespace Database\Seeders;

use App\Models\BooksCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BooksCategory::updateOrCreate(
            ['id' => 1],
            ['name' => 'Mystery']
        );
        BooksCategory::updateOrCreate(
            ['id' => 2],
            ['name' => 'Coomic']
        );
        BooksCategory::updateOrCreate(
            ['id' => 3],
            ['name' => 'Poetry']
        );
        BooksCategory::updateOrCreate(
            ['id' => 4],
            ['name' => 'Biography']
        );
    }
}
