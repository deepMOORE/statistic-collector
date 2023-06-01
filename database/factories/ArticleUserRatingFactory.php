<?php

namespace Database\Factories;

use App\DbModels\ArticleUserRating;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\DbModels\ArticleUserRating>
 */
class ArticleUserRatingFactory extends Factory
{
    protected $model = ArticleUserRating::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating' => fake()->numberBetween(100, 1000) / 100,
        ];
    }
}
