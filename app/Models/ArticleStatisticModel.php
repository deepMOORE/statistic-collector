<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Collection;

class ArticleStatisticModel
{
    public int $articleId;

    public string $title;

    public float $periodValue;

    public Collection $stats;
}
