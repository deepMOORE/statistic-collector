<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Collection;

class ArticleClientModel
{
    public function __construct(
        public int $id,
        public string $title,
        public string $publishedAt,
        public string $content,
        public int $viewCount,
        public Collection $tags,
        public ?float $rating,
        public string $ratingColor,
    ) {
    }
}
