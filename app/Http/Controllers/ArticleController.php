<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController
{
    public function __construct(
        private readonly ArticleService $articleService,
    ) {
    }

    public function viewWelcome()
    {
        $articles = $this->articleService->getAllClientModels();

        return view('welcome', [
            'articles' => $articles,
        ]);
    }

    public function viewCreate()
    {
        return view('articles.create-article');
    }

    public function viewEdit(int $id)
    {
        $article = $this->articleService->getById($id);

        return view('articles.edit-article', ['article' => $article]);
    }

    public function create(Request $request)
    {
        $this->articleService->create(
            $request->get('title'),
            $request->get('content')
        );

        return redirect('/');
    }

    public function delete(Request $request)
    {
        $this->articleService->delete(
            (int)$request->get('id'),
        );

        return redirect('/');
    }

    public function edit(Request $request)
    {
        $this->articleService->edit(
            (int)$request->get('id'),
            $request->get('title'),
            $request->get('content'),
        );

        return redirect('/');
    }
}
