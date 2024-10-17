<?php

namespace Database\Seeders;

use App\Models\Quote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Quote::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Duis faucibus enim vitae nunc molestie, nec nec arcu facilisis arcu Nullam mattis bibendum aac, dui accres.. vitae nunc molestie, nec nec arcu facilisis arcu Nullam mattis bibendum aac,..',
                'author_id' => 1
            ]);
        Quote::updateOrCreate(
            ['id' => 2],
            [
                'title' => 'lorem asfaegt aehgaeyg aytg hjuydtju djuae taetya egaszgaet aet aet hjcnchj djudtjuh',
                'author_id' => 1
            ]);
        Quote::updateOrCreate(
            ['id' => 3],
            [
                'title' => 'dfh kilset aet ae tas ydtu dudtu seryt sy sy dfh kilset aet ae tas ydtu dudtu seryt sy sy dfh kilset aet ae tas ydtu dudtu seryt sy sy dfh kilset aet ae tas ydtu dudtu seryt sy sy dfh kilset aet ae tas ydtu dudtu seryt sy sy ',
                'author_id' => 1
            ]);
    }
}
