<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Response;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;

class ArticleController extends AuthenticatedUserController
{
    public function __construct(
        private readonly ArticleService $articleService,
    ) {
    }

    public function getAll(): JsonResponse
    {
        $userId = $this->getCurrentUserId();

        $articles = $this->articleService->getByUser($userId);

        return Response::success($articles);
    }
}
