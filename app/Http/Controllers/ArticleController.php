<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Response;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;

class ArticleController
{
    public function __construct(
        private readonly ArticleService $articleService,
    ) {
    }

    public function getAll(): JsonResponse
    {
        $articles = $this->articleService->getAll();

        return Response::success($articles);
    }
}
