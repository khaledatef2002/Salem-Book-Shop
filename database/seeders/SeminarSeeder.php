<?php

namespace Database\Seeders;

use App\Models\Seminar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeminarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Seminar::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Event Test',
                'description' => 'Test Description',
                'date' => "2025/10/17",
            ]);
    }
}
