<?php declare(strict_types=1);

namespace App\DataAccess\Repositories;

use App\Models\ArticleModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ArticleRepository extends BaseRepository
{
    public function create(string $title, string $content): int
    {
        return $this->query()
            ->insertGetId([
                'title' => $title,
                'published_at' => Carbon::now(),
                'content' => $content,
            ]);
    }

    public function getById(int $id): ArticleModel
    {
        $article = $this->query()
            ->where('id', $id)
            ->first() ?? throw new \Error();

        return $this->map($article);
    }

    public function delete(int $id): int
    {
        return $this->query()
            ->where('id', $id)
            ->delete();
    }

    public function update(int $id, string $title, string $content): void
    {
        $this->query()
            ->where('id', $id)
            ->update([
                'title' => $title,
                'content' => $content,
                'published_at' => Carbon::now(),
            ]);
    }

    public function getAll(): Collection
    {
        return $this->query()
            ->select([
                'id',
                'title',
                'published_at',
                'views_count',
                'content',
            ])
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
        );
    }

    protected function getTable(): string
    {
        return 'articles';
    }
}
