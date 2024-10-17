<?php

namespace Database\Seeders;

use App\Models\Person;
use App\PeopleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Person::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'William Shakespeare',
                'type' => PeopleType::Author->value,
                'about' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Totam esse quae natus nihil atque illo error consequatur nisi expedita perspiciatis labore officiis similique, saepe accusamus quia quas in, molestias obcaecati!',
                'image' => 'uploads/persons/1.png'
            ]);
        Person::updateOrCreate(
            ['id' => 2],
            [
                'name' => 'William Shakespeare',
                'type' => PeopleType::Instructor->value,
                'about' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Totam esse quae natus nihil atque illo error consequatur nisi expedita perspiciatis labore officiis similique, saepe accusamus quia quas in, molestias obcaecati!',
                'image' => 'uploads/persons/1.png'
            ]);
    }
}
