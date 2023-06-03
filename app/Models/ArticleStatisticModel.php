<?php declare(strict_types=1);

namespace App\Models;

class ArticleStatisticModel
{
    public int $articleId;

    public string $title;

    public float $maxValue;

    public float $minValue;

    public string $datesStr;

    public string $valuesStr;
}
