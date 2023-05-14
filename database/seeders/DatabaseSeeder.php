<?php

namespace Database\Seeders;

use App\DbModels\Article;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Article::query()->forceDelete();

        Article::factory(random_int(50, 120))->create();
    }
}
