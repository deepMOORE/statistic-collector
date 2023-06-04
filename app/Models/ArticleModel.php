<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ArticleModel
{
    public function __construct(
        public int $id,
        public string $title,
        public Carbon $publishedAt,
        public string $content,
        public int $viewCount,
        public Collection $tags,
        public ?float $rating,
    ) {
    }
}
