<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ArticleCategory::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Sport'
            ]
        );
        ArticleCategory::updateOrCreate(
            ['id' => 2],
            [
                'name' => 'Technologies'
            ]
        );
        Article::updateOrCreate(
            ['id' => 1],
            [
                'title' => 'Test Article 1',
                'user_id' => 1,
                'content' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni error, nihil iusto quos, a enim sint natus deleniti nisi fuga repellat sapiente rerum? Aut harum distinctio fuga ea maxime aspernatur.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni error, nihil iusto quos, a enim sint natus deleniti nisi fuga repellat sapiente rerum? Aut harum distinctio fuga ea maxime aspernatur.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni error, nihil iusto quos, a enim sint natus deleniti nisi fuga repellat sapiente rerum? Aut harum distinctio fuga ea maxime aspernatur.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni error, nihil iusto quos, a enim sint natus deleniti nisi fuga repellat sapiente rerum? Aut harum distinctio fuga ea maxime aspernatur.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni error, nihil iusto quos, a enim sint natus deleniti nisi fuga repellat sapiente rerum? Aut harum distinctio fuga ea maxime aspernatur.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni error, nihil iusto quos, a enim sint natus deleniti nisi fuga repellat sapiente rerum? Aut harum distinctio fuga ea maxime aspernatur.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni error, nihil iusto quos, a enim sint natus deleniti nisi fuga repellat sapiente rerum? Aut harum distinctio fuga ea maxime aspernatur.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni error, nihil iusto quos, a enim sint natus deleniti nisi fuga repellat sapiente rerum? Aut harum distinctio fuga ea maxime aspernatur.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni error, nihil iusto quos, a enim sint natus deleniti nisi fuga repellat sapiente rerum? Aut harum distinctio fuga ea maxime aspernatur.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni error, nihil iusto quos, a enim sint natus deleniti nisi fuga repellat sapiente rerum? Aut harum distinctio fuga ea maxime aspernatur.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni error, nihil iusto quos, a enim sint natus deleniti nisi fuga repellat sapiente rerum? Aut harum distinctio fuga ea maxime aspernatur.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni error, nihil iusto quos, a enim sint natus deleniti nisi fuga repellat sapiente rerum? Aut harum distinctio fuga ea maxime aspernatur.Lorem ipsum dolor sit amet consectetur, adipisicing elit. Magni error, nihil iusto quos, a enim sint natus deleniti nisi fuga repellat sapiente rerum? Aut harum distinctio fuga ea maxime aspernatur.',
                'cover' => 'imgs/article-1.png',
                'category_id' => 1
            ]
        );
    }
}
