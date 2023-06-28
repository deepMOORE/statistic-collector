<?php declare(strict_types=1);

namespace App\DataAccess\Repositories;

use App\DbModels\Article;
use App\Models\ArticleModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ArticleRepository
{
    public function getAll(): Collection
    {
        return Article::query()
            ->select([
                'id',
                'title',
                'published_at',
                'views_count',
                'content',
                'rating',
            ])
            ->limit(100)
            ->orderByDesc('published_at')
            ->get()
            ->map(fn(object $x) => $this->map($x));
    }

    private function map(object $rawArticle): ArticleModel
    {
        return new ArticleModel(
            $rawArticle->id,
            $rawArticle->title,
            Carbon::make($rawArticle->published_at),
            $rawArticle->content,
            $rawArticle->views_count,
            $rawArticle->rating === null ? null : (float)$rawArticle->rating,
        );
    }
}
