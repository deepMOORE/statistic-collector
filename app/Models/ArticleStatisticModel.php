<?php declare(strict_types=1);

namespace App\Models;

class ArticleStatisticModel
{
    public int $articleId;

    public string $title;

    public string $datesStr;

    public string $valuesStr;

    public string $anomalyIndexes;
}
