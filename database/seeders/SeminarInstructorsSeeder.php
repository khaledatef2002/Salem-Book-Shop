<?php

namespace Database\Seeders;

use App\Models\SeminarInstructor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeminarInstructorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SeminarInstructor::updateOrCreate(
            [
                'seminar_id' => 1,
                'instructor_id' => 2
            ]);
    }
}
