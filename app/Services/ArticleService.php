<?php declare(strict_types=1);

namespace App\Services;

use App\DataAccess\Repositories\ArticleRepository;
use App\Models\ArticleModel;
use Illuminate\Support\Collection;

class ArticleService
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
    ) {
    }

    /**
     * @return Collection<ArticleModel>
     */
    public function getAll(): Collection
    {
        return $this->articleRepository->getAll();
    }
}
