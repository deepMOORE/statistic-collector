<?php

namespace Database\Seeders;

use App\DbModels\Article;
use App\DbModels\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Article::query()->forceDelete();
        Tag::query()->forceDelete();

        Article::factory(random_int(50, 120))->create();

        $tags = [];
        Article::query()->get()->each(function (Article $x) use (&$tags) {
            $tags[] = Tag::factory(random_int(2, 10))->make([
                'article_id' => $x->id,
            ])->toArray();
        });

        Tag::query()->insert(Arr::flatten($tags, 1));
    }
}
