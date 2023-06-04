<?php declare(strict_types=1);

namespace App\Services;

use App\DataAccess\Repositories\ArticleRepository;
use App\DataAccess\Repositories\TagRepository;
use App\Models\ArticleClientModel;
use App\Models\ArticleModel;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ArticleService
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly TagRepository $tagRepository,
    ) {
    }

    /**
     * @return Collection<ArticleModel>
     */
    public function getAll(): Collection
    {
        return $this->articleRepository->getAll();
    }

    public function getById(int $id): ArticleModel
    {
        return $this->articleRepository->getById($id);
    }

    /**
     * @return Collection<ArticleClientModel>
     */
    public function getAllClientModels(): Collection
    {
        return $this->getAll()
            ->map(fn (ArticleModel $x) => new ArticleClientModel(
                $x->id,
                $x->title,
                $this->parsePublishingDate($x->publishedAt),
                $x->content,
                $x->viewCount,
                $x->tags,
                $x->rating,
                $this->getRatingColor($x->rating),
            ));
    }

    private function getRatingColor(?float $rating): string
    {
        $color = 'grey';

        if ($rating === null) {
            return $color;
        }

        if ($rating <= 4.0) {
            return 'red';
        }

        if ($rating <= 7.0) {
            return 'grey';
        }

        return 'green';
    }

    public function create(string $title, string $content): int
    {
        return $this->articleRepository->create($title, $content);
    }

    public function delete(int $id): void
    {
        $this->articleRepository->delete($id);
        $this->tagRepository->deleteByArticle($id);
    }

    public function edit(int $id, string $title, string $content): void
    {
        $this->articleRepository->update($id, $title, $content);
    }

    private function parsePublishingDate(Carbon $date): string
    {
        $now = Carbon::now();

        $formattedDate = $date->format('Y-m-d');

        $diffInHours = $now->diffInHours($date);

        if ($diffInHours < 1) {
            return 'just now';
        }

        if ($diffInHours < 24) {
            return '(' . $formattedDate . ') ' . $diffInHours . ' hours ago';
        }

        if ($diffInHours < 24 * 7) {
            return '(' . $formattedDate . ') ' . $now->diffInDays($date) . ' days ago';
        }

        if ($diffInHours < 24 * 7 * 4) {
            return '(' . $formattedDate . ') ' . $now->diffInWeeks($date) . ' weeks ago';
        }

        if ($diffInHours < 365 * 24) {
            return '(' . $formattedDate . ') ' . $now->diffInMonths($date) . ' months ago';
        }

        return '(' . $formattedDate . ') ' . $now->diffInYears($date) . ' years ago';
    }
}
