<?php declare(strict_types=1);

namespace App\DbModels;

use Database\Factories\StatisticViewsFactory;

class StatisticViews extends BaseModel
{
    protected $table = 'statistics_views';

    protected $casts = [
        'period_date' => 'datetime',
    ];

    protected static function newFactory()
    {
        return StatisticViewsFactory::new();
    }
}
