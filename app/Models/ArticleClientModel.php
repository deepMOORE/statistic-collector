<?php declare(strict_types=1);

namespace App\Models;

class ArticleClientModel
{
    public function __construct(
        public int $id,
        public string $title,
        public string $publishedAt,
        public string $content,
        public int $viewCount,
    ) {
    }
}
