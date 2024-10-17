<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(BooksCategoriesSeeder::class);
        $this->call(PeopleSeeder::class);
        $this->call(BooksSeeder::class);
        $this->call(BooksImagesSeeder::class);
        $this->call(QuoteSeeder::class);
        $this->call(SeminarSeeder::class);
        $this->call(SeminarInstructorsSeeder::class);
    }
}
