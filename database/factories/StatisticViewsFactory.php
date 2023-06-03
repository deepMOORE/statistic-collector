<?php declare(strict_types=1);

namespace Database\Factories;

use App\DbModels\StatisticViews;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatisticViewsFactory extends Factory
{
    protected $model = StatisticViews::class;

    public function definition()
    {
        return [
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
