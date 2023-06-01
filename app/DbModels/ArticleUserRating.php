<?php

namespace App\DbModels;

use Database\Factories\ArticleUserRatingFactory;

class ArticleUserRating extends BaseModel
{
    protected static function newFactory()
    {
        return ArticleUserRatingFactory::new();
    }
}
