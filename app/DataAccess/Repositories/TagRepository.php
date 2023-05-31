<?php declare(strict_types=1);

namespace App\DataAccess\Repositories;

use App\DbModels\Tag;

class TagRepository
{
    public function deleteByArticle(int $articleId)
    {
        Tag::query()->where('article_id', $articleId)->forceDelete();
    }
}
