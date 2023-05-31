<?php declare(strict_types=1);

namespace Database\Factories;

use App\DbModels\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'title' => fake()->realText(10),
            'rating' => random_int(0, 100) > 30 ? fake()->numberBetween(100, 1000) / 100 : null,
            'content' => fake()->realTextBetween(200, 600),
            'published_at' => fake()->dateTimeBetween('-4 months'),
        ];
    }
}
